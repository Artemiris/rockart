<?php

use yii\db\Migration;

/**
 * Handles the creation of table `area`.
 */
class m201201_064407_create_area_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('area', [
            'id' => $this->primaryKey(),
            'archsite_id' => $this->integer()->notNull(),
            'image' => $this->string(),
            'lat' => $this->double(),
            'lng' => $this->double()
        ]);

        $this->addForeignKey('fk-area-archsite',
            'area',
            'archsite_id',
            'archsite',
            'id',
            'RESTRICT'
        );

        $this->createTable('area_language', [
            'id' => $this->primaryKey(),
            'area_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()
        ]);

        $this->addForeignKey(
            'fk-area_language-area',
            'area_language',
            'area_id',
            'area',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-area-archsite','area');
        $this->dropForeignKey('fk-area_language-area', 'area_language');
        $this->dropTable('area_language');
        $this->dropTable('area');
    }
}