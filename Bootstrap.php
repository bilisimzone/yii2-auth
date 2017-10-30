<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace coreb2c\auth;

use Yii;
use yii\authclient\Collection;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use yii\i18n\PhpMessageSource;
use coreb2c\auth\components\DbManager;
use coreb2c\auth\components\ManagerInterface;
use yii\base\Application;
use yii\web\Application as WebApplication;
use yii\base\InvalidConfigException;

/**
 * Bootstrap class registers module and user application component. It also creates some url rules which will be applied
 * when UrlManager.enablePrettyUrl is enabled.
 *
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class Bootstrap implements BootstrapInterface {

    const VERSION = '1.0.0-alpha';

    /** @var array Model's map */
    private $_modelMap = [
        'User' => 'coreb2c\auth\models\User',
        'Account' => 'coreb2c\auth\models\Account',
        'Profile' => 'coreb2c\auth\models\Profile',
        'Token' => 'coreb2c\auth\models\Token',
        'RegistrationForm' => 'coreb2c\auth\models\RegistrationForm',
        'ResendForm' => 'coreb2c\auth\models\ResendForm',
        'LoginForm' => 'coreb2c\auth\models\LoginForm',
        'SettingsForm' => 'coreb2c\auth\models\SettingsForm',
        'RecoveryForm' => 'coreb2c\auth\models\RecoveryForm',
        'UserSearch' => 'coreb2c\auth\models\UserSearch',
    ];

    /** @inheritdoc */
    public function bootstrap($app) {
        // register translations
        if (!isset($app->get('i18n')->translations['auth*'])) {
            $app->get('i18n')->translations['auth*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US',
            ];
        }
        if ($this->checkRbacEnabled($app)) {
            $authManager = $app->get('authManager', false);

            if (!$authManager) {
                $app->set('authManager', [
                    'class' => DbManager::className(),
                ]);
            } else if (!($authManager instanceof ManagerInterface)) {
                throw new InvalidConfigException('You have wrong authManager configuration');
            }
        }

        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('auth') && ($module = $app->getModule('auth')) instanceof Module) {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);
            foreach ($this->_modelMap as $name => $definition) {
                $class = "coreb2c\\auth\\models\\" . $name;
                Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
                if (in_array($name, ['User', 'Profile', 'Token', 'Account'])) {
                    Yii::$container->set($name . 'Query', function () use ($modelName) {
                        return $modelName::find();
                    });
                }
            }

            Yii::$container->setSingleton(Finder::className(), [
                'userQuery' => Yii::$container->get('UserQuery'),
                'profileQuery' => Yii::$container->get('ProfileQuery'),
                'tokenQuery' => Yii::$container->get('TokenQuery'),
                'accountQuery' => Yii::$container->get('AccountQuery'),
            ]);

            if ($app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'coreb2c\auth\commands';
            } else {
                Yii::$container->set('yii\web\User', [
                    'enableAutoLogin' => true,
                    'loginUrl' => ['/auth/security/login'],
                    'identityClass' => $module->modelMap['User'],
                ]);

                $configUrlRule = [
                    'prefix' => $module->urlPrefix,
                    'rules' => $module->urlRules,
                ];

                if ($module->urlPrefix != 'auth') {
                    $configUrlRule['routePrefix'] = 'auth';
                }

                $configUrlRule['class'] = 'yii\web\GroupUrlRule';
                $rule = Yii::createObject($configUrlRule);

                $app->urlManager->addRules([$rule], false);

                if (!$app->has('authClientCollection')) {
                    $app->set('authClientCollection', [
                        'class' => Collection::className(),
                    ]);
                }
            }
            Yii::$container->set('coreb2c\auth\Mailer', $module->mailer);

            $module->debug = $this->ensureCorrectDebugSetting();
        }
    }

    /**
     * Verifies that coreb2c/yii2-rbac is enabled
     * @param  Application $app
     * @return bool
     */
    protected function checkRbacEnabled(Application $app) {
        if ($app instanceof WebApplication) {
            return $app->hasModule('auth') && $app->getModule('auth') instanceof Module && $app->getModule('auth')->enableRbac;
        } else {
            return $app->hasModule('auth') && $app->getModule('auth') instanceof AuthConsoleModule;
        }
    }

    /** Ensure the module is not in DEBUG mode on production environments */
    public function ensureCorrectDebugSetting() {
        if (!defined('YII_DEBUG')) {
            return false;
        }
        if (!defined('YII_ENV')) {
            return false;
        }
        if (defined('YII_ENV') && YII_ENV !== 'dev') {
            return false;
        }
        if (defined('YII_DEBUG') && YII_DEBUG !== true) {
            return false;
        }

        return Yii::$app->getModule('auth')->debug;
    }

    /**
     * Verifies that authManager component is configured.
     * @param  Application $app
     * @return bool
     */
    protected function checkAuthManagerConfigured(Application $app) {
        return $app->authManager instanceof ManagerInterface;
    }

}
