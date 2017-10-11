<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use coreb2c\auth\migrations\Migration;

class m151218_234654_add_timezone_to_profile extends Migration
{
    public function up()
    {
        $this->addColumn('{{%profile}}', 'timezone', $this->string(40)->null());
    }

    public function down()
    {
        $this->dropcolumn('{{%profile}}', 'timezone');
    }
}
