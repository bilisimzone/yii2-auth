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
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

/**
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class Permission extends AuthItem
{
    /**
     * @inheritdoc
     */
    public function getUnassignedItems()
    {
        return ArrayHelper::map($this->manager->getItems(Item::TYPE_PERMISSION, $this->item !== null ? [$this->item->name] : []), 'name', function ($item) {
            return empty($item->description) ? $item->name : $item->name . ' (' . $item->description . ')';
        });
    }

    /** 
     * @inheritdoc
     */
    protected function createItem($name)
    {
        return $this->manager->createPermission($name);
    }
}