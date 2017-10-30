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

use yii\rbac\Role;
use yii\web\NotFoundHttpException;
use yii\rbac\Item;

/**
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class RoleController extends ItemControllerAbstract
{
    /** @var string */
    protected $modelClass = 'coreb2c\auth\models\Role';
    
    protected $type = Item::TYPE_ROLE;

    /** @inheritdoc */
    protected function getItem($name)
    {
        $role = \Yii::$app->authManager->getRole($name);

        if ($role instanceof Role) {
            return $role;
        }

        throw new NotFoundHttpException;
    }
}