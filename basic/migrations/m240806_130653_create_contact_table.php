<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 */
class m240806_130653_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'email' => $this->string(50)->notNull()->unique(),
            'subject' => $this->string(50)->notNull(),
            'body' => $this->string(50)->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact}}');
    }
}
