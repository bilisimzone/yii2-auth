<?php

/*
 * This file is part of the CoreB2C project.
 *
 * (c) CoreB2C project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\models;

use coreb2c\auth\components\DbManager;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\di\Instance;

/**
 * Rule model.
 *
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class Rule extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $class;

    /**
     * @var string|DbManager The auth manager component ID.
     */
    public $authManager = 'authManager';

    /**
     * @var string
     */
    private $_oldName;

    /**
     * @param string $oldName
     */
    public function setOldName($oldName)
    {
        $this->_oldName = $oldName;
    }

    /**
     * This method will set [[authManager]] to be the 'authManager' application component, if it is `null`.
     */
    public function init()
    {
        parent::init();

        $this->authManager = Instance::ensure($this->authManager, DbManager::className());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name', 'class'],
            self::SCENARIO_UPDATE => ['name', 'class'],
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'class'], 'trim'],
            [['name', 'class'], 'required'],
            ['name', 'match', 'pattern' => '/^[\w][\w-.:]+[\w]$/'],
            ['name', function () {
                if ($this->name == $this->_oldName) {
                    return;
                }
                $rule = $this->authManager->getRule($this->name);

                if ($rule instanceof \yii\auth\Rule) {
                    $this->addError('name', \Yii::t('auth', 'Name is already in use'));
                }
            }],
            ['class', function () {
                if (!class_exists($this->class)) {
                    $this->addError('class', \Yii::t('auth', 'Class "{0}" does not exist', $this->class));
                } else {
                    try {
                        $class = '\yii\auth\Rule';
                        $rule  = \Yii::createObject($this->class);

                        if (!($rule instanceof $class)) {
                            $this->addError('class', \Yii::t('auth', 'Rule class must extend "yii\rbac\Rule"'));
                        }
                    } catch (InvalidConfigException $e) {
                        $this->addError('class', \Yii::t('auth', 'Rule class can not be instantiated'));
                    }
                }
            }],
        ];
    }

    /**
     * Creates new auth rule.
     * 
     * @return bool
     * @throws InvalidConfigException
     */
    public function create()
    {
        if ($this->scenario != self::SCENARIO_CREATE) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        $rule = \Yii::createObject([
            'class' => $this->class,
            'name'  => $this->name,
        ]);
        
        $this->authManager->add($rule);
        $this->authManager->invalidateCache();
        
        return true;
    }

    /**
     * Updates existing auth rule.
     * 
     * @return bool
     * @throws InvalidConfigException
     */
    public function update()
    {
        if ($this->scenario != self::SCENARIO_UPDATE) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        $rule = \Yii::createObject([
            'class' => $this->class,
            'name'  => $this->name,
        ]);
        
        $this->authManager->update($this->_oldName, $rule);
        $this->authManager->invalidateCache();
        
        return true;
    }
}