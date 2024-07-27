<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%custom_user}}`.
 */
class m240726_162434_create_custom_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%custom_user}}', [
            'id' => $this->primaryKey(),
            'fullname' => $this->string(50)->notNull(),
            'email' => $this->string(50)->notNull()->unique(),
            'username' => $this->string(50)->notNull(),
            'password' => $this->string(50)->notNull(),
            'authKey' => $this->char(50)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%custom_user}}');
    }
}
