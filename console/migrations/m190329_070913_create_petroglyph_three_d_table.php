<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%petroglyph_three_d}}`.
 */
class m190329_070913_create_petroglyph_three_d_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('petroglyph_three_d', [
            'id' => $this->primaryKey(),
            'url' => $this->string(),
            'petroglyph_id' => $this->integer(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('petroglyph_three_d_language', [
            'id' => $this->primaryKey(),
            'petroglyph_three_d_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-petroglyph_three_d_language-petroglyph_three_d',
            'petroglyph_three_d_language',
            'petroglyph_three_d_id',
            'petroglyph_three_d',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-petroglyph_three_d-petroglyph',
            'petroglyph_three_d',
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
            'fk-petroglyph_three_d_language-petroglyph_three_d',
            'petroglyph_three_d_language'
        );

        $this->dropTable('petroglyph_three_d_language');

        $this->dropTable('petroglyph_three_d');
    }
}
