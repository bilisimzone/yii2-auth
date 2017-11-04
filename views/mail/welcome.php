<?php
/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var coreb2c\auth\Module $module
 * @var coreb2c\auth\models\User $user
 * @var coreb2c\auth\models\Token $token
 * @var bool $showPassword
 */
?>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('auth', 'Hello') ?>,
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('auth', 'Your account on {0} has been created', Yii::$app->name) ?>.
</p>
<?php if ($showPassword || $module->enableGeneratingPassword): ?>
    <p><?= Yii::t('auth', 'Your login credentials are as below') ?>:</p>
    <hr>
    <table width="250" style="width: 250px;" >
        <tbody>
            <tr>
                <td style="text-align: left;"><?= Yii::t('auth', 'Email') ?>:</td><th style="text-align: left;"><?= $user->email ?></th>
            </tr>
            <?php if ($module->enableLoginWithUsernameOrEmail === true || $module->enableLoginWithUsername === true): ?>
                <tr>
                    <td style="text-align: left;"><?= Yii::t('auth', 'Username') ?>:</td><th style="text-align: left;"><?= $user->username ?></th>
                </tr>
            <?php endif; ?>
            <tr>
                <td style="text-align: left;"><?= Yii::t('auth', 'Password') ?>:</td><th style="text-align: left;"><?= $user->password ?></th>
            </tr>
        </tbody>
    </table>
    <hr>
<?php endif ?>

<?php if ($token !== null): ?>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
        <?= Yii::t('auth', 'In order to complete your registration, please click the link below') ?>.
    </p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
        <?= Html::a(Html::encode($token->url), $token->url); ?>
    </p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
        <?= Yii::t('auth', 'If you cannot click the link, please try pasting the text into your browser') ?>.
    </p>
<?php endif ?>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('auth', 'If you did not make this request you can ignore this email') ?>.
</p>
