<?php

/*
 * This file is part of the CoreB2C project.
 *
 * (c) CoreB2C project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\widgets;

use yii\bootstrap\Nav;

/**
 * Menu widget.
 *
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class Menu extends Nav
{
    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'nav-tabs'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $userModuleClass       = 'coreb2c\auth\Module';
        $isUserModuleInstalled = \Yii::$app->getModule('auth') instanceof $userModuleClass;

        $this->items = [
            [
                'label'   => \Yii::t('rbac', 'Users'),
                'url'     => ['/auth/admin/index'],
                'visible' => $isUserModuleInstalled,
            ],
            [
                'label' => \Yii::t('rbac', 'Roles'),
                'url'   => ['/rbac/role/index'],
            ],
            [
                'label' => \Yii::t('rbac', 'Permissions'),
                'url'   => ['/rbac/permission/index'],
            ],
            [
                'label' => \Yii::t('rbac', 'Rules'),
                'url'   => ['/rbac/rule/index'],
            ],
            [
                'label' => \Yii::t('rbac', 'Create'),
                'items' => [
                    [
                        'label'   =>\ Yii::t('rbac', 'New user'),
                        'url'     => ['/auth/admin/create'],
                        'visible' => $isUserModuleInstalled,
                    ],
                    [
                        'label' => \Yii::t('rbac', 'New role'),
                        'url'   => ['/rbac/role/create']
                    ],
                    [
                        'label' => \Yii::t('rbac', 'New permission'),
                        'url'   => ['/rbac/permission/create']
                    ],
                    [
                        'label' => \Yii::t('rbac', 'New rule'),
                        'url'   => ['/rbac/rule/create']
                    ]
                ]
            ],
        ];
    }
}