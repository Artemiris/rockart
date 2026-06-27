<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%petroglyph_image}}`.
 */
class m190212_091932_create_petroglyph_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('petroglyph_image', [
            'id' => $this->primaryKey(),
            'file' => $this->string(),
            'petroglyph_id' => $this->integer(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('petroglyph_image_language', [
            'id' => $this->primaryKey(),
            'petroglyph_image_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-petroglyph_image_language-petroglyph_image',
            'petroglyph_image_language',
            'petroglyph_image_id',
            'petroglyph_image',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-petroglyph_image-petroglyph',
            'petroglyph_image',
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
            'fk-petroglyph_image_language-petroglyph_image',
            'petroglyph_image_language'
        );

        $this->dropTable('petroglyph_image_language');

        $this->dropTable('petroglyph_image');
    }
}
