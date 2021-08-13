<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%my_object}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%my_object}}`
 */
class m210812_193406_create_my_object_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%my_object}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'image_path' => $this->string(1024)->notNull(),
            'parent_id' => $this->integer(),
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            '{{%idx-my_object-parent_id}}',
            '{{%my_object}}',
            'parent_id'
        );

//        // add foreign key for table `{{%my_object}}`
//        $this->addForeignKey(
//            '{{%fk-my_object-parent_id}}',
//            '{{%my_object}}',
//            'parent_id',
//            '{{%my_object}}',
//            'id',
//            'CASCADE'
//        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%my_object}}`
        $this->dropForeignKey(
            '{{%fk-my_object-parent_id}}',
            '{{%my_object}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            '{{%idx-my_object-parent_id}}',
            '{{%my_object}}'
        );

        $this->dropTable('{{%my_object}}');
    }
}
