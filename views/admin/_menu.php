<?php

/*
 * This file is part of the Coreb2c project
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px',
    ],
    'items' => [
        [
            'label' => Yii::t('user', 'Users'),
            'url' => ['/auth/admin/index'],
        ],
        [
            'label' => Yii::t('user', 'Roles'),
            'url' => ['/auth/role/index'],
            'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
        ],
        [
            'label' => Yii::t('user', 'Permissions'),
            'url' => ['/auth/permission/index'],
            'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
        ],
        [
            'label' => \Yii::t('user', 'Rules'),
            'url'   => ['/auth/rule/index'],
            'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
        ],
        [
            'label' => Yii::t('user', 'Create'),
            'items' => [
                [
                    'label' => Yii::t('user', 'New user'),
                    'url' => ['/auth/admin/create'],
                ],
                [
                    'label' => Yii::t('user', 'New role'),
                    'url' => ['/auth/role/create'],
                    'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
                ],
                [
                    'label' => Yii::t('user', 'New permission'),
                    'url' => ['/auth/permission/create'],
                    'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
                ],
                [
                    'label' => \Yii::t('user', 'New rule'),
                    'url'   => ['/auth/rule/create'],
                    'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
                ]
            ],
        ],
    ],
]) ?>
