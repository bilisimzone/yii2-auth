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

use coreb2c\auth\models\Profile;
use yii\base\Event;

/**
 * @property Profile $model
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class ProfileEvent extends Event
{
    /**
     * @var Profile
     */
    private $_profile;

    /**
     * @return Profile
     */
    public function getProfile()
    {
        return $this->_profile;
    }

    /**
     * @param Profile $form
     */
    public function setProfile(Profile $form)
    {
        $this->_profile = $form;
    }
}
