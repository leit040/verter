<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%my_object}}`
 */
class m210812_193704_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'task_list' => $this->text()->notNull(),
            'my_object_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `my_object_id`
        $this->createIndex(
            '{{%idx-task-my_object_id}}',
            '{{%task}}',
            'my_object_id'
        );

        // add foreign key for table `{{%my_object}}`
        $this->addForeignKey(
            '{{%fk-task-my_object_id}}',
            '{{%task}}',
            'my_object_id',
            '{{%my_object}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%my_object}}`
        $this->dropForeignKey(
            '{{%fk-task-my_object_id}}',
            '{{%task}}'
        );

        // drops index for column `my_object_id`
        $this->dropIndex(
            '{{%idx-task-my_object_id}}',
            '{{%task}}'
        );

        $this->dropTable('{{%task}}');
    }
}
