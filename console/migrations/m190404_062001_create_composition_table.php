<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%composition}}`.
 */
class m190404_062001_create_composition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('composition', [
            'id' => $this->primaryKey(),
            'image' => $this->string(),
            'index' => $this->string(),
            'petroglyph_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('composition_language', [
            'id' => $this->primaryKey(),
            'composition_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'description' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-composition_language-composition',
            'composition_language',
            'composition_id',
            'composition',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-composition-petroglyph',
            'composition',
            'petroglyph_id',
            'petroglyph',
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
            'fk-composition-petroglyph',
            'composition'
        );

        $this->dropForeignKey(
            'fk-composition_language-composition',
            'composition_language'
        );

        $this->dropTable('composition_language');

        $this->dropTable('composition');
    }
}
