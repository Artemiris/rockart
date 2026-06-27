<?php

use yii\db\Migration;

/**
 * Class m190403_100507_update_petroglyph_table
 */
class m190403_100507_update_petroglyph_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('petroglyph', 'archsite_id', $this->integer());
        $this->addForeignKey(
            'fk-petroglyph-archsite',
            'petroglyph',
            'archsite_id',
            'archsite',
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
            'fk-petroglyph-archsite',
            'petroglyph'
        );
        $this->dropColumn('petroglyph', 'archsite_id');
    }

}
