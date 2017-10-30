<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View                   $this
 * @var yii\widgets\ActiveForm         $form
 * @var coreb2c\auth\models\LoginForm $model
 * @var string                         $action
 */
?>

<?php if (Yii::$app->user->isGuest): ?>
    <?php

    $form = ActiveForm::begin([
                'id' => 'login-widget-form',
                'action' => Url::to(['/auth/security/login']),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
            ])
    ?>

    <?= $form->field($model, 'login')->textInput(['placeholder' => 'Login']) ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <?= Html::submitButton(Yii::t('auth', 'Sign in'), ['class' => 'btn btn-primary btn-block']) ?>

    <?php ActiveForm::end(); ?>
<?php else: ?>
    <?=

    Html::a(Yii::t('auth', 'Logout'), ['/auth/security/logout'], [
        'class' => 'btn btn-danger btn-block',
        'data-method' => 'post'
    ])
    ?>
<?php endif ?>
