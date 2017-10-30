<?php

/*
 * This file is part of the CoreB2C project.
 *
 * (c) CoreB2C project <http://github.com/coreb2c/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @var string $className the new migration class name
 */

echo "<?php\n";
?>

use coreb2c\auth\migrations\Migration;

class <?= $className ?> extends Migration
{
    public function safeUp()
    {
    
    }
    
    public function safeDown()
    {
        echo "<?= $className ?> cannot be reverted.\n";
        
        return false;
    }
}
