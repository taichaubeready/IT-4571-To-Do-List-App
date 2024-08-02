<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_images}}`.
 */
class m240729_143458_create_user_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%user_images}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_images}}');
    }
}
