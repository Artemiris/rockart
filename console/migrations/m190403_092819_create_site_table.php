<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site}}`.
 */
class m190403_092819_create_site_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('archsite', [
            'id' => $this->primaryKey(),
            'image' => $this->string(),
            'lat' => $this->double(),
            'lng' => $this->double(),
            'registry_num' => $this->string(),
            'index' => $this->string(),
        ]);

        $this->createTable('archsite_language', [
            'id' => $this->primaryKey(),
            'archsite_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'publication' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-archsite_language-archsite',
            'archsite_language',
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
            'fk-archsite_language-archsite',
            'archsite_language'
        );

        $this->dropTable('archsite_language');

        $this->dropTable('archsite');
    }

}
