<?php
/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var coreb2c\auth\models\User $user
 */
$this->title = Yii::t('auth', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('auth', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('auth'),]) ?>

<?= $this->render('_menu') ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?=
                Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        ['label' => Yii::t('auth', 'Account details'), 'url' => ['/auth/admin/create']],
                        ['label' => Yii::t('auth', 'Profile details'), 'options' => [
                                'class' => 'disabled',
                                'onclick' => 'return false;',
                            ]],
                        ['label' => Yii::t('auth', 'Information'), 'options' => [
                                'class' => 'disabled',
                                'onclick' => 'return false;',
                            ]],
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-info">
                    <?= Yii::t('auth', 'If not provided a password will be generated automatically') ?>.
                </div>
                <?php
                $form = ActiveForm::begin([
                            'layout' => 'horizontal',
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'fieldConfig' => [
                                'horizontalCssClasses' => [
                                    'wrapper' => 'col-sm-9',
                                ],
                            ],
                ]);
                ?>

                <?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('auth', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
