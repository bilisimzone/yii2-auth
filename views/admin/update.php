<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\Nav;

/**
 * @var \yii\web\View $this
 * @var \coreb2c\auth\models\User $user
 * @var string $content
 */

$this->title = Yii::t('auth', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('auth', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('auth')]) ?>

<?= $this->render('_menu') ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        [
                            'label' => Yii::t('auth', 'Account details'),
                            'url' => ['/auth/admin/update', 'id' => $user->id]
                        ],
                        [
                            'label' => Yii::t('auth', 'Profile details'),
                            'url' => ['/auth/admin/update-profile', 'id' => $user->id]
                        ],
                        ['label' => Yii::t('auth', 'Information'), 'url' => ['/auth/admin/info', 'id' => $user->id]],
                        [
                            'label' => Yii::t('auth', 'Assignments'),
                            'url' => ['/auth/admin/assignments', 'id' => $user->id],
                            'visible' => isset(Yii::$app->extensions['coreb2c/yii2-auth']),
                        ],
                        '<hr>',
                        [
                            'label' => Yii::t('auth', 'Confirm'),
                            'url' => ['/auth/admin/confirm', 'id' => $user->id],
                            'visible' => !$user->isConfirmed,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('auth', 'Are you sure you want to confirm this user?'),
                            ],
                        ],
                        [
                            'label' => Yii::t('auth', 'Block'),
                            'url' => ['/auth/admin/block', 'id' => $user->id],
                            'visible' => !$user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('auth', 'Are you sure you want to block this user?'),
                            ],
                        ],
                        [
                            'label' => Yii::t('auth', 'Unblock'),
                            'url' => ['/auth/admin/block', 'id' => $user->id],
                            'visible' => $user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('auth', 'Are you sure you want to unblock this user?'),
                            ],
                        ],
                        [
                            'label' => Yii::t('auth', 'Delete'),
                            'url' => ['/auth/admin/delete', 'id' => $user->id],
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('auth', 'Are you sure you want to delete this user?'),
                            ],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
