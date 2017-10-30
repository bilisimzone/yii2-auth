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
            'label' => Yii::t('auth', 'Users'),
            'url' => ['/auth/admin/index'],
        ],
        [
            'label' => Yii::t('auth', 'Roles'),
            'url' => ['/auth/role/index'],
            'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
        ],
        [
            'label' => Yii::t('auth', 'Permissions'),
            'url' => ['/auth/permission/index'],
            'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
        ],
        [
            'label' => \Yii::t('auth', 'Rules'),
            'url'   => ['/auth/rule/index'],
            'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
        ],
        [
            'label' => Yii::t('auth', 'Create'),
            'items' => [
                [
                    'label' => Yii::t('auth', 'New user'),
                    'url' => ['/auth/admin/create'],
                ],
                [
                    'label' => Yii::t('auth', 'New role'),
                    'url' => ['/auth/role/create'],
                    'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
                ],
                [
                    'label' => Yii::t('auth', 'New permission'),
                    'url' => ['/auth/permission/create'],
                    'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
                ],
                [
                    'label' => \Yii::t('auth', 'New rule'),
                    'url'   => ['/auth/rule/create'],
                    'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
                ]
            ],
        ],
    ],
]) ?>
