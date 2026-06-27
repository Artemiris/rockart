<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%petroglyph}}`.
 */
class m190212_091931_create_petroglyph_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('petroglyph', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(64),
            'lat' => $this->decimal(8, 5),
            'lng' => $this->decimal(8, 5),
            'image' => $this->string(),

            'orientation_x' => $this->decimal(8, 7),
            'orientation_y' => $this->decimal(8, 7),
            'orientation_z' => $this->decimal(8, 7),

            'method_id' => $this->integer(),
            'culture_id' => $this->integer(),
            'epoch_id' => $this->integer(),

            'deleted' => $this->tinyInteger(1),
            'public' => $this->tinyInteger(1),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('petroglyph_language', [
            'id' => $this->primaryKey(),
            'petroglyph_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-petroglyph_language-petroglyph',
            'petroglyph_language',
            'petroglyph_id',
            'petroglyph',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-petroglyph-method',
            'petroglyph',
            'method_id',
            'method',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-petroglyph-culture',
            'petroglyph',
            'culture_id',
            'culture',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-petroglyph-epoch',
            'petroglyph',
            'epoch_id',
            'epoch',
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
            'fk-petroglyph-epoch',
            'petroglyph'
        );

        $this->dropForeignKey(
            'fk-petroglyph-culture',
            'petroglyph'
        );

        $this->dropForeignKey(
            'fk-petroglyph-method',
            'petroglyph'
        );

        $this->dropForeignKey(
            'fk-petroglyph_language-petroglyph',
            'petroglyph_language'
        );

        $this->dropTable('petroglyph_language');

        $this->dropTable('petroglyph');
    }
}
