<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%job}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m240807_151522_create_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%job}}', [
            'id' => $this->primaryKey(),
            'action' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->string()->notNull(),
            'count_action' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-job-user_id}}',
            '{{%job}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-job-user_id}}',
            '{{%job}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-job-user_id}}',
            '{{%job}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-job-user_id}}',
            '{{%job}}'
        );

        $this->dropTable('{{%job}}');
    }
}
