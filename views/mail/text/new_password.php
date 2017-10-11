<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var coreb2c\auth\models\User
 */
?>
<?= Yii::t('user', 'Hello') ?>,

<?= Yii::t('user', 'Your account on {0} has a new password', Yii::$app->name) ?>.
<?= Yii::t('user', 'We have generated a password for you') ?>:
<?= $user->password ?>

<?= Yii::t('user', 'If you did not make this request you can ignore this email') ?>.
