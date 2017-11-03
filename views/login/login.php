<?php
/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use coreb2c\auth\widgets\Connect;
use coreb2c\auth\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var coreb2c\auth\models\LoginForm $model
 * @var coreb2c\auth\Module $module
 */
$this->title = Yii::t('auth', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('auth')]) ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'validateOnBlur' => false,
                            'validateOnType' => false,
                            'validateOnChange' => false,
                        ])
                ?>

                <?php if ($module->debug): ?>
                    <?=
                    $form->field($model, 'login', [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'class' => 'form-control',
                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                    ?>

                <?php else: ?>
                    <?php if ($module->enableLoginWithUsernameOrEmail === true) { ?>
                        <?= $form->field($model, 'login', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]); ?>
                    <?php } elseif ($module->enableLoginWithUsernameOrEmail === false and $module->enableLoginWithEmail === true) { ?>
                        <?= $form->field($model, 'login', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']])->input('email'); ?>
                    <?php } else { ?>
                        <?= $form->field($model, 'login', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]); ?>
                    <?php } ?>
                <?php endif ?>

                <?php if ($module->debug): ?>
                    <div class="alert alert-warning">
                        <?= Yii::t('auth', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                    </div>
                <?php else: ?>
                    <?=
                            $form->field(
                                    $model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
                            ->passwordInput()
                            ->label(
                                    Yii::t('auth', 'Password')
                                    . ($module->enablePasswordRecovery ?
                                            ' (' . Html::a(
                                                    Yii::t('auth', 'Forgot password?'), ['/auth/recovery/request'], ['tabindex' => '5']
                                            )
                                            . ')' : '')
                            )
                    ?>
                <?php endif ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>

                <?=
                Html::submitButton(
                        Yii::t('auth', 'Sign in'), ['class' => 'btn btn-primary btn-block', 'tabindex' => '4']
                )
                ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('auth', 'Didn\'t receive confirmation message?'), ['/auth/registration/resend']) ?>
            </p>
        <?php endif ?>
        <?php if ($module->enableRegistration): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('auth', 'Don\'t have an account? Sign up!'), ['/auth/registration/register']) ?>
            </p>
        <?php endif ?>
        <?=
        Connect::widget([
            'baseAuthUrl' => ['/auth/security/auth'],
        ])
        ?>
    </div>
</div>
