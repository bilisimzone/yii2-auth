<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\widgets;

use coreb2c\auth\models\LoginForm;
use yii\base\Widget;

/**
 * Login for widget.
 *
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class Login extends Widget
{
    /**
     * @var bool
     */
    public $validate = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('login', [
            'model' => \Yii::createObject(LoginForm::className()),
        ]);
    }
}
