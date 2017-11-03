<?php

namespace coreb2c\auth\components;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class RbacController extends Controller {

    public function init() {
        parent::init();
        $module = \Yii::$app->getModule('auth');
        if ($module->enableRbac !== true) {
            throw new ForbiddenHttpException(\Yii::t('auth', 'Role Base Access Control (RBAC) is not enabled'));
        }
    }

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => [$this, 'checkAccess'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Checks access.
     *
     * @return bool
     */
    public function checkAccess() {
        $user = \Yii::$app->user->identity;

        if (method_exists($user, 'getIsAdmin')) {
            return $user->getIsAdmin();
        } else if ($this->module->adminPermission) {
            return $this->module->adminPermission ? \Yii::$app->user->can($this->module->adminPermission) : false;
        } else {
            return isset($user->username) ? in_array($user->username, $this->admins) : false;
        }
    }

}
