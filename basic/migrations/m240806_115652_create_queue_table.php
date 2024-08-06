<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queue}}`.
 */
class m240806_115652_create_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%queue}}', [
            'id' => $this->primaryKey()->notNull(),
            'channel' => $this->string(255)->notNull(),
            'job' => $this->binary()->notNull(),
            'pushed_at' => $this->integer(11)->notNull(),
            'ttr' => $this->integer(11)->notNull(),
            'delay' => $this->integer(11)->notNull()->defaultValue(0),
            'priority' => $this->integer(11)->notNull()->defaultValue(1024),
            'reserved_at' => $this->integer(11)->null(),
            'attempt' => $this->integer(11)->null(),
            'done_at' => $this->integer(11)->null(),
        ], $tableOptions);

        $this->createIndex('channel', '{{%queue}}', 'channel');
        $this->createIndex('reserved_at', '{{%queue}}', 'reserved_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%queue}}');
    }
}
