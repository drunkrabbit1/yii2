<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210320_164144_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),

            'firstname' => $this->string()->notNull(),
            'lastname' => $this->string()->notNull(),

            'access_token' => $this->string(32),
            'auth_key' => $this->string(32)->notNull(),

            'auth_status' => $this->boolean()->defaultValue(false),
            'password' => $this->string()->notNull(),

            'email' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
