<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use coreb2c\auth\migrations\Migration;

/**
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com
 */
class m140403_174025_create_account_table extends Migration {

    public function up() {
        $this->createTable('{{%social_account}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'provider' => $this->string()->notNull(),
            'client_id' => $this->string()->notNull(),
            'data' => $this->text()->null(),
            'code' => $this->string(32)->null(),
            'created_at' => $this->integer()->null(),
            'email' => $this->string()->null(),
            'username' => $this->string()->null(),
                ], $this->tableOptions);

        $this->createIndex('{{%account_unique}}', '{{%account}}', ['provider', 'client_id'], true);
        $this->createIndex('{{%account_unique_code}}', '{{%social_account}}', 'code', true);
        $this->addForeignKey('{{%fk_user_account}}', '{{%account}}', 'user_id', '{{%user}}', 'id', $this->cascade, $this->restrict);
    }

    public function down() {
        $this->dropTable('{{%account}}');
    }

}
