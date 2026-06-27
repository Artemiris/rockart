<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%drawing}}`.
 */
class m190409_101853_create_drawing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('drawing', [
            'id' => $this->primaryKey(),
            'image' => $this->string(),
            'index' => $this->string(),
            'composition_id' => $this->integer()->notNull(),
            'method_id' => $this->integer(),
            'culture_id' => $this->integer(),
            'epoch_id' => $this->integer(),
        ]);

        $this->createTable('drawing_language', [
            'id' => $this->primaryKey(),
            'drawing_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'description' => $this->text(),
            'dating' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk-drawing_language-drawing',
            'drawing_language',
            'drawing_id',
            'drawing',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-drawing-composition',
            'drawing',
            'composition_id',
            'composition',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-drawing-composition',
            'drawing'
        );

        $this->dropForeignKey(
            'fk-drawing_language-drawing',
            'drawing_language'
        );

        $this->dropTable('drawing_language');

        $this->dropTable('drawing');
    }
}
