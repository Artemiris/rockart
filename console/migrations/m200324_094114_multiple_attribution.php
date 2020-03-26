<?php

use yii\db\Migration;
use yii\db\query;

/**
 * Class m200324_094114_multiple_attribution
 */
class m200324_094114_multiple_attribution extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-petroglyph-style',
            'petroglyph'
        );
        $this->createTable('petroglyph_culture', [
            'id' => $this->primaryKey(),
            'petroglyph_id' => $this->integer()->notNull(),
            'culture_id' => $this->integer()->notNull(),
        ]);
        $this->createTable('petroglyph_method', [
            'id' => $this->primaryKey(),
            'petroglyph_id' => $this->integer()->notNull(),
            'method_id' => $this->integer()->notNull(),
        ]);
        $this->createTable('petroglyph_epoch', [
            'id' => $this->primaryKey(),
            'petroglyph_id' => $this->integer()->notNull(),
            'epoch_id' => $this->integer()->notNull(),
        ]);
        $this->createTable('petroglyph_style', [
            'id' => $this->primaryKey(),
            'petroglyph_id' => $this->integer()->notNull(),
            'style_id' => $this->integer()->notNull(),
        ]);

        foreach((new Query)->from('petroglyph')->each() as $petroglyph) {
            if ($petroglyph['culture_id'])
                $this->insert('petroglyph_culture', ['culture_id' => $petroglyph['culture_id'], 'petroglyph_id' => $petroglyph['id']]);
            if ($petroglyph['method_id'])
                $this->insert('petroglyph_method', ['method_id' => $petroglyph['method_id'], 'petroglyph_id' => $petroglyph['id']]);
            if ($petroglyph['epoch_id'])
                $this->insert('petroglyph_epoch', ['epoch_id' => $petroglyph['epoch_id'], 'petroglyph_id' => $petroglyph['id']]);
            if ($petroglyph['style_id'])
                $this->insert('petroglyph_style', ['style_id' => $petroglyph['style_id'], 'petroglyph_id' => $petroglyph['id']]);
        }
        $this->dropColumn('petroglyph', 'culture_id');
        $this->dropColumn('petroglyph', 'method_id');
        $this->dropColumn('petroglyph', 'epoch_id');
        $this->dropColumn('petroglyph', 'style_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('petroglyph', 'culture_id', $this->integer());
        $this->addColumn('petroglyph', 'method_id', $this->integer());
        $this->addColumn('petroglyph', 'epoch_id', $this->integer());
        $this->addColumn('petroglyph', 'style_id', $this->integer());
        foreach((new Query)->from('petroglyph_culture')->each() as $petroglyph_culture)
            $this->update('petroglyph', ['culture_id' => $petroglyph_culture['culture_id']], ['id' => $petroglyph_culture['petroglyph_id']]);
        foreach((new Query)->from('petroglyph_method')->each() as $petroglyph_method)
            $this->update('petroglyph', ['method_id' => $petroglyph_method['method_id']], ['id' => $petroglyph_method['petroglyph_id']]);
        foreach((new Query)->from('petroglyph_epoch')->each() as $petroglyph_epoch)
            $this->update('petroglyph', ['epoch_id' => $petroglyph_epoch['epoch_id']], ['id' => $petroglyph_epoch['petroglyph_id']]);
        foreach((new Query)->from('petroglyph_style')->each() as $petroglyph_style)
            $this->update('petroglyph', ['style_id' => $petroglyph_style['style_id']], ['id' => $petroglyph_style['petroglyph_id']]);

        $this->dropTable('petroglyph_culture');
        $this->dropTable('petroglyph_method');
        $this->dropTable('petroglyph_epoch');
        $this->dropTable('petroglyph_style');

        $this->addForeignKey(
            'fk-petroglyph-style',
            'petroglyph',
            'style_id',
            'style',
            'id',
            'CASCADE'
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200324_094114_multiple_attribution cannot be reverted.\n";

        return false;
    }
    */
}
