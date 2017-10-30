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
                'label'   => \Yii::t('auth', 'Users'),
                'url'     => ['/auth/admin/index'],
                'visible' => $isUserModuleInstalled,
            ],
            [
                'label' => \Yii::t('auth', 'Roles'),
                'url'   => ['/auth/role/index'],
            ],
            [
                'label' => \Yii::t('auth', 'Permissions'),
                'url'   => ['/auth/permission/index'],
            ],
            [
                'label' => \Yii::t('auth', 'Rules'),
                'url'   => ['/auth/rule/index'],
            ],
            [
                'label' => \Yii::t('auth', 'Create'),
                'items' => [
                    [
                        'label'   =>\ Yii::t('auth', 'New user'),
                        'url'     => ['/auth/admin/create'],
                        'visible' => $isUserModuleInstalled,
                    ],
                    [
                        'label' => \Yii::t('auth', 'New role'),
                        'url'   => ['/auth/role/create']
                    ],
                    [
                        'label' => \Yii::t('auth', 'New permission'),
                        'url'   => ['/auth/permission/create']
                    ],
                    [
                        'label' => \Yii::t('auth', 'New rule'),
                        'url'   => ['/auth/rule/create']
                    ]
                ]
            ],
        ];
    }
}