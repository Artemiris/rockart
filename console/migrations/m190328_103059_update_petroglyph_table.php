<?php

use yii\db\Migration;

/**
 * Class m190328_103059_update_petroglyph_table
 */
class m190328_103059_update_petroglyph_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('petroglyph', 'index', $this->string());
        $this->addColumn('petroglyph_language', 'technical_description', $this->text());
        $this->addColumn('petroglyph_language', 'publication', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('petroglyph_language', 'publication');
        $this->dropColumn('petroglyph_language', 'technical_description');
        $this->dropColumn('petroglyph', 'index');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190328_103059_update_petroglyph_table cannot be reverted.\n";

        return false;
    }
    */
}
