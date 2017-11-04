<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\models;

use coreb2c\auth\Finder;
use coreb2c\auth\helpers\Password;
use coreb2c\auth\traits\ModuleTrait;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Yii;
use yii\base\Model;

/**
 * LoginForm get user's login and password, validates them and logs the user in. If user has been blocked, it adds
 * an error to login form.
 *
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class LoginForm extends Model {

    use ModuleTrait;

    /** @var string User's email or username */
    public $login;

    /** @var string User's plain password */
    public $password;

    /** @var string Whether to remember the user */
    public $rememberMe = false;

    /** @var \coreb2c\auth\models\User */
    protected $user;

    /** @var Finder */
    protected $finder;

    /**
     * @param Finder $finder
     * @param array  $config
     */
    public function __construct(Finder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($config);
    }

    /**
     * Gets all users to generate the dropdown list when in debug mode.
     *
     * @return string
     */
    public static function loginList() {
        return ArrayHelper::map(User::find()->where(['blocked_at' => null])->all(), 'username', function ($user) {
                    return sprintf('%s (%s)', Html::encode($user->username), Html::encode($user->email));
                });
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'login' => (($this->module->enableLoginWithUsernameOrEmail === true) ? Yii::t('auth', 'Username or Email') : (($this->module->enableLoginWithUsernameOrEmail === false and $this->module->enableLoginWithEmail === true) ? Yii::t('auth', 'Email') : Yii::t('auth', 'Username'))),
            'password' => Yii::t('auth', 'Password'),
            'rememberMe' => Yii::t('auth', 'Remember me next time'),
        ];
    }

    /** @inheritdoc */
    public function rules() {
        $user = $this->module->modelMap['User'];
        $rules = [
            'requiredFields' => [['login'], 'required'],
            'loginTrim' => ['login', 'trim'],
            'loginExistance' => [
                'login',
                function ($attribute) {
                    if ($this->user === null) {
                        $this->addError($attribute, Yii::t('auth', 'Invalid username'));
                    }
                }
            ],
            'confirmationValidate' => [
                'login',
                function ($attribute) {
                    if ($this->user !== null) {
                        $confirmationRequired = $this->module->enableConfirmation && !$this->module->enableUnconfirmedLogin;
                        if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                            $this->addError($attribute, Yii::t('auth', 'You need to confirm your email address'));
                        }
                        if ($this->user->getIsBlocked()) {
                            $this->addError($attribute, Yii::t('auth', 'Your account has been blocked'));
                        }
                    }
                }
            ],
            'rememberMe' => ['rememberMe', 'boolean'],
        ];
        if ($this->module->enableLoginWithUsernameOrEmail === false and $this->module->enableLoginWithEmail == true) {
            $rules = array_merge($rules, [
                'loginType' => [['login'], 'email']
            ]);
        }
        if ($this->module->enableLoginWithUsernameOrEmail === false and $this->module->enableLoginWithEmail == false and $this->module->enableLoginWithUsername === true) {
            $rules = array_merge($rules, [
                'usernameLength' => ['login', 'string', 'min' => 3, 'max' => 255],
                'usernamePattern' => ['login', 'match', 'pattern' => $user::$usernameRegexp],
            ]);
        }
        if (!$this->module->debug) {
            $rules = array_merge($rules, [
                'requiredFields' => [['login', 'password'], 'required'],
                'passwordValidate' => [
                    'password',
                    function ($attribute) {
                        if ($this->user !== null && !Password::validate($this->password, $this->user->password_hash)) {
                            $this->addError($attribute, Yii::t('auth', 'Invalid password'));
                        }
                    }
                ]
            ]);
        }

        return $rules;
    }

    /**
     * Validates if the hash of the given password is identical to the saved hash in the database.
     * It will always succeed if the module is in DEBUG mode.
     *
     * @return void
     */
    public function validatePassword($attribute, $params) {
        if ($this->user !== null && !Password::validate($this->password, $this->user->password_hash)) {
            $this->addError($attribute, Yii::t('auth', 'Invalid password'));
        }
    }

    /**
     * Validates form and logs the user in.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            $this->user->updateAttributes(['last_login_at' => time()]);
            return Yii::$app->getUser()->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
        }

        return false;
    }

    /** @inheritdoc */
    public function formName() {
        return 'login-form';
    }

    /** @inheritdoc */
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if ($this->module->enableLoginWithUsernameOrEmail === true) {
                $this->user = $this->finder->findUserByUsernameOrEmail(trim($this->login), $this->module->userCategory);
            } elseif ($this->module->enableLoginWithEmail === true) {
                $this->user = $this->finder->findUserByEmail(trim($this->login), $this->module->userCategory);
            } else {
                $this->user = $this->finder->findUserByUsername(trim($this->login), $this->module->userCategory);
            }
            return true;
        } else {
            return false;
        }
    }

}
