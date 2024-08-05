<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_photos}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m240805_093112_create_user_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%user_photos}}', [
            'id' => $this->primaryKey(),
            'photos' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull()->unique(),
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_photos-user_id}}',
            '{{%user_photos}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_photos-user_id}}',
            '{{%user_photos}}',
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
            '{{%fk-user_photos-user_id}}',
            '{{%user_photos}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_photos-user_id}}',
            '{{%user_photos}}'
        );

        $this->dropTable('{{%user_photos}}');
    }
}
