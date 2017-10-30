<?php

/*
 * This file is part of the CoreB2C project.
 *
 * (c) CoreB2C project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $model coreb2c\auth\models\Role
 * @var $this  yii\web\View
 */

$this->title = Yii::t('auth', 'Update role');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginContent('@coreb2c/auth/views/layout.php') ?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

<?php $this->endContent() ?>