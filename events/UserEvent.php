<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\events;

use coreb2c\auth\models\User;
use yii\base\Event;

/**
 * @property User $model
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class UserEvent extends Event
{
    /**
     * @var User
     */
    private $_user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param User $form
     */
    public function setUser(User $form)
    {
        $this->_user = $form;
    }
}
