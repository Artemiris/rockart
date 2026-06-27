<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%style}}`.
 */
class m190411_092337_create_style_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('style', [
            'id' => $this->primaryKey(),
        ]);

        $this->createTable('style_language', [
            'id' => $this->primaryKey(),
            'style_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-style_language-style',
            'style_language',
            'style_id',
            'style',
            'id',
            'CASCADE'
        );

        $this->addColumn('petroglyph', 'style_id', $this->integer());
        $this->addForeignKey(
            'fk-petroglyph-style',
            'petroglyph',
            'style_id',
            'style',
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
            'fk-petroglyph-style',
            'petroglyph'
        );
        $this->dropColumn('petroglyph', 'style_id');
        
        $this->dropForeignKey(
            'fk-style_language-style',
            'style_language'
        );

        $this->dropTable('style_language');

        $this->dropTable('style');
    }
}
