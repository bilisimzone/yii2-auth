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
class Menu extends Nav {

    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'nav-tabs'
    ];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        $userModuleClass = 'coreb2c\auth\Module';
        $module = \Yii::$app->getModule('auth');
        $isRbacEnabled = $module->enableRbac === true;

        $this->items = [
            [
                'label' => \Yii::t('auth', 'Users'),
                'url' => ['/auth/admin/index'],
            ],
            [
                'label' => \Yii::t('auth', 'Roles'),
                'url' => ['/auth/role/index'],
                'visible' => $isRbacEnabled,
            ],
            [
                'label' => \Yii::t('auth', 'Permissions'),
                'url' => ['/auth/permission/index'],
                'visible' => $isRbacEnabled,
            ],
            [
                'label' => \Yii::t('auth', 'Rules'),
                'url' => ['/auth/rule/index'],
                'visible' => $isRbacEnabled,
            ],
            [
                'label' => \Yii::t('auth', 'Create'),
                'items' => [
                    [
                        'label' => \ Yii::t('auth', 'New user'),
                        'url' => ['/auth/admin/create'],
                    ],
                    [
                        'label' => \Yii::t('auth', 'New role'),
                        'url' => ['/auth/role/create'],
                        'visible' => $isRbacEnabled,
                    ],
                    [
                        'label' => \Yii::t('auth', 'New permission'),
                        'url' => ['/auth/permission/create'],
                        'visible' => $isRbacEnabled,
                    ],
                    [
                        'label' => \Yii::t('auth', 'New rule'),
                        'url' => ['/auth/rule/create'],
                        'visible' => $isRbacEnabled,
                    ]
                ]
            ],
        ];
    }

}
