<?php

/*
 * This file is part of the Coreb2c project
 *
 * (c) Coreb2c project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\clients;

use yii\authclient\clients\Twitter as BaseTwitter;
use yii\helpers\ArrayHelper;

/**
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class Twitter extends BaseTwitter implements ClientInterface
{
    /**
     * @return string
     */
    public function getUsername()
    {
        return ArrayHelper::getValue($this->getUserAttributes(), 'screen_name');
    }

    /**
     * @return null Twitter does not provide user's email address
     */
    public function getEmail()
    {
        return null;
    }
}
