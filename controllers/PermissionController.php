<?php

/*
 * This file is part of the CoreB2C project.
 *
 * (c) CoreB2C project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\controllers;

use yii\auth\Permission;
use yii\web\NotFoundHttpException;
use yii\rbac\Item;

/**
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class PermissionController extends ItemControllerAbstract
{
    /** @var string */
    protected $modelClass = 'coreb2c\auth\models\Permission';
    
    /** @var int */
    protected $type = Item::TYPE_PERMISSION;

    /** @inheritdoc */
    protected function getItem($name)
    {
        $role = \Yii::$app->authManager->getPermission($name);

        if ($role instanceof Permission) {
            return $role;
        }

        throw new NotFoundHttpException;
    }
}