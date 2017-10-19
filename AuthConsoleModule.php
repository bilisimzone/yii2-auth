<?php

namespace coreb2c\Auth;

use yii\base\Module;

/**
 * Rbac console module.
 * 
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class AuthConsoleModule extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'coreb2c\rbac\commands';
}