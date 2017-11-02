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

/**
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com
 */
class m140209_132017_init extends Migration {

    public function up() {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'password_hash' => $this->string(60)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'confirmed_at' => $this->integer()->null(),
            'unconfirmed_email' => $this->string(255)->null(),
            'blocked_at' => $this->integer()->null(),
            'registered_ip' => $this->bigInteger()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'flags' => $this->integer()->notNull()->defaultValue(0),
            'last_login_at' => $this->integer(),
            'group' => $this->integer()->notNull()->defaultValue(1),
                ], $this->tableOptions);

        $this->createIndex('{{%user_unique_username}}', '{{%user}}', 'username', true);
        $this->createIndex('{{%user_unique_email}}', '{{%user}}', 'email', true);

        $this->createTable('{{%profile}}', [
            'user_id' => $this->integer()->notNull()->append('PRIMARY KEY'),
            'name' => $this->string(255)->null(),
            'public_email' => $this->string(255)->null(),
            'gravatar_email' => $this->string(255)->null(),
            'gravatar_id' => $this->string(32)->null(),
            'location' => $this->string(255)->null(),
            'website' => $this->string(255)->null(),
            'bio' => $this->text()->null(),
            'timezone' => $this->string(40)->null(),
                ], $this->tableOptions);

        $this->addForeignKey('{{%fk_user_profile}}', '{{%profile}}', 'user_id', '{{%user}}', 'id', $this->cascade, $this->restrict);
    }

    public function down() {
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user}}');
    }

}
