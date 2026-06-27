<?php

use yii\db\Migration;

/**
 * Class m210421_000546_add_field_petroglyph_author_page
 */
class m210421_000546_add_field_petroglyph_author_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('petroglyph_language', 'author_page', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('petroglyph_language', 'author_page');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210421_000546_add_field_petroglyph_author_page cannot be reverted.\n";

        return false;
    }
    */
}
