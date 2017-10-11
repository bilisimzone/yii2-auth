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
 * @var yii\web\View $this
 * @var coreb2c\auth\Module $module
 */

$this->title = $title;
?>

<?= $this->render('/_alert', ['module' => $module]);
