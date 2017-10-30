<?php

/*
 * This file is part of the CoreB2C project.
 *
 * (c) CoreB2C project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\validators;

use yii\validators\Validator;

/**
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class RbacValidator extends Validator
{
    /** @var \coreb2c\auth\components\DbManager */
    protected $manager;
    
    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->manager = \Yii::$app->authManager;
    }
    
    /** @inheritdoc */
    protected function validateValue($value)
    {
        if (!is_array($value)) {
            return [\Yii::t('auth', 'Invalid value'), []];
        }
        
        foreach ($value as $val) {
            if ($this->manager->getItem($val) == null) {
                return [\Yii::t('auth', 'There is neither role nor permission with name "{0}"', [$val]), []];
            }
        }
    }
}