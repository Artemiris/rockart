<?php

use yii\db\Migration;

/**
 * Class m210430_120248_alter_table_petroglyph_language_add_images_fields
 */
class m210430_120248_alter_table_petroglyph_language_add_images_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('petroglyph_language', 'img_author', $this->string());
        $this->addColumn('petroglyph_language', 'img_copyright', $this->string());
        $this->addColumn('petroglyph_language', 'img_source', $this->string());
        $this->addColumn('petroglyph_language', 'ds_img_author', $this->string());
        $this->addColumn('petroglyph_language', 'ds_img_copyright', $this->string());
        $this->addColumn('petroglyph_language', 'ds_img_source', $this->string());
        $this->addColumn('petroglyph_language', 'dr_img_author', $this->string());
        $this->addColumn('petroglyph_language', 'dr_img_copyright', $this->string());
        $this->addColumn('petroglyph_language', 'dr_img_source', $this->string());
        $this->addColumn('petroglyph_language', 'ov_img_author', $this->string());
        $this->addColumn('petroglyph_language', 'ov_img_copyright', $this->string());
        $this->addColumn('petroglyph_language', 'ov_img_source', $this->string());
        $this->addColumn('petroglyph_language', 're_img_author', $this->string());
        $this->addColumn('petroglyph_language', 're_img_copyright', $this->string());
        $this->addColumn('petroglyph_language', 're_img_source', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('petroglyph_language', 'img_author');
        $this->dropColumn('petroglyph_language', 'img_copyright');
        $this->dropColumn('petroglyph_language', 'img_source');
        $this->dropColumn('petroglyph_language', 'ds_img_author');
        $this->dropColumn('petroglyph_language', 'ds_img_copyright');
        $this->dropColumn('petroglyph_language', 'ds_img_source');
        $this->dropColumn('petroglyph_language', 'dr_img_author');
        $this->dropColumn('petroglyph_language', 'dr_img_copyright');
        $this->dropColumn('petroglyph_language', 'dr_img_source');
        $this->dropColumn('petroglyph_language', 'ov_img_author');
        $this->dropColumn('petroglyph_language', 'ov_img_copyright');
        $this->dropColumn('petroglyph_language', 'ov_img_source');
        $this->dropColumn('petroglyph_language', 're_img_author');
        $this->dropColumn('petroglyph_language', 're_img_copyright');
        $this->dropColumn('petroglyph_language', 're_img_source');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210430_120248_alter_table_petroglyph_language_add_images_fields cannot be reverted.\n";

        return false;
    }
    */
}
