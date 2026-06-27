<?php

use yii\db\Migration;

/**
 * Class m201203_204554_alter_table_petroglyph_add_area_id
 */
class m201203_204554_alter_table_petroglyph_add_area_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('petroglyph', 'area_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('petroglyph', 'area_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201203_204554_alter_table_petroglyph_add_area_id cannot be reverted.\n";

        return false;
    }
    */
}
