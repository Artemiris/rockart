<?php

use yii\db\Migration;

/**
 * Class m201221_153843_add_foreignkey_petroglyph_area_id
 */
class m201221_153843_add_foreignkey_petroglyph_area_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_petroglyph_area',
            'petroglyph',
            'area_id',
            'area',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_petroglyph_area', 'petroglyph');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201221_153843_add_foreignkey_petroglyph_area_id cannot be reverted.\n";

        return false;
    }
    */
}