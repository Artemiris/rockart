<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%method}}`.
 */
class m190212_091920_create_method_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('method', [
            'id' => $this->primaryKey(),
        ]);

        $this->createTable('method_language', [
            'id' => $this->primaryKey(),
            'method_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-method_language-method',
            'method_language',
            'method_id',
            'method',
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
            'fk-method_language-method',
            'method_language'
        );

        $this->dropTable('method_language');

        $this->dropTable('method');
    }
}
