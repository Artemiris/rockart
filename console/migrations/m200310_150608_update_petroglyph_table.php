<?php

use yii\db\Migration;

/**
 * Class m200310_150608_update_petroglyph_table
 */
class m200310_150608_update_petroglyph_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('petroglyph', 'im_dstretch', $this->string());
        $this->addColumn('petroglyph', 'im_drawing', $this->string());
        $this->addColumn('petroglyph', 'im_reconstruction', $this->string());
        $this->addColumn('petroglyph', 'im_overlay', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('petroglyph', 'im_dstretch');
        $this->dropColumn('petroglyph', 'im_drawing');
        $this->dropColumn('petroglyph', 'im_reconstruction');
        $this->dropColumn('petroglyph', 'im_overlay');
    }

}
