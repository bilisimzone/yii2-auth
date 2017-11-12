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
use coreb2c\auth\Mailer;
use coreb2c\auth\traits\ModuleTrait;
use Yii;
use yii\base\Model;

/**
 * Model for collecting data on password recovery.
 *
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class RecoveryForm extends Model {

    use ModuleTrait;

    const SCENARIO_REQUEST = 'request';
    const SCENARIO_RESET = 'reset';

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $password;

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var Finder
     */
    protected $finder;

    /** @var \coreb2c\auth\models\User */
    protected $user;

    /**
     * @param Mailer $mailer
     * @param Finder $finder
     * @param array  $config
     */
    public function __construct(Mailer $mailer, Finder $finder, $config = []) {
        $this->mailer = $mailer;
        $this->finder = $finder;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'login' => (($this->module->enableLoginWithUsernameOrEmail === true) ? Yii::t('auth', 'Username or Email') : (($this->module->enableLoginWithUsernameOrEmail === false and $this->module->enableLoginWithEmail === true) ? Yii::t('auth', 'Email') : Yii::t('auth', 'Username'))),
            'password' => \Yii::t('auth', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return [
            self::SCENARIO_REQUEST => ['login'],
            self::SCENARIO_RESET => ['password'],
        ];
    }

    /**
     * @inheritdoc
     */
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
            'passwordRequired' => ['password', 'required'],
            'passwordLength' => ['password', 'string', 'max' => 72, 'min' => 6],
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
        return $rules;
    }

    /**
     * Sends recovery message.
     *
     * @return bool
     */
    public function sendRecoveryMessage() {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->user;

        if ($user instanceof User) {
            /** @var Token $token */
            $token = \Yii::createObject([
                        'class' => Token::className(),
                        'user_id' => $user->id,
                        'type' => Token::TYPE_RECOVERY,
            ]);

            if (!$token->save(false)) {
                return false;
            }

            if (!$this->mailer->sendRecoveryMessage($user, $token)) {
                return false;
            }
        }

        \Yii::$app->session->setFlash(
                'info', \Yii::t('auth', 'An email has been sent with instructions for resetting your password')
        );

        return true;
    }

    /**
     * Resets user's password.
     *
     * @param Token $token
     *
     * @return bool
     */
    public function resetPassword(Token $token) {
        if (!$this->validate() || $token->user === null) {
            return false;
        }

        if ($token->user->resetPassword($this->password)) {
            \Yii::$app->session->setFlash('success', \Yii::t('auth', 'Your password has been changed successfully.').'  <a class="btn btn-sm btn-primary" href="'.\yii\helpers\Url::toRoute('/auth/login').'">'.\Yii::t('auth', 'Sign in').'</a>');
            $token->delete();
        } else {
            \Yii::$app->session->setFlash(
                    'danger', \Yii::t('auth', 'An error occurred and your password has not been changed. Please try again later.')
            );
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function formName() {
        return 'recovery-form';
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
