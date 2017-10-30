<?php


namespace coreb2c\auth\traits;

use coreb2c\auth\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package coreb2c\auth\traits
 */
trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return \Yii::$app->getModule('auth');
    }
}
