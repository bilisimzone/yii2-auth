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

use yii\authclient\clients\LinkedIn as BaseLinkedIn;

/**
 * @author Sam Mousa <sam@mousa.nl>
 */
class LinkedIn extends BaseLinkedIn implements ClientInterface
{
    /** @inheritdoc */
    public function getEmail()
    {
        return isset($this->getUserAttributes()['email-address'])
            ? $this->getUserAttributes()['email-address']
            : null;
    }

    /** @inheritdoc */
    public function getUsername()
    {
        return;
    }
}
