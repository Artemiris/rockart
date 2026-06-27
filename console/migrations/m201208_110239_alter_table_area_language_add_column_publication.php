<?php

use yii\db\Migration;

/**
 * Class m201208_110239_alter_table_area_language_add_column_publication
 */
class m201208_110239_alter_table_area_language_add_column_publication extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('area_language', 'publication', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('area_language', 'publication');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201208_110239_alter_table_area_language_add_columns cannot be reverted.\n";

        return false;
    }
    */
}