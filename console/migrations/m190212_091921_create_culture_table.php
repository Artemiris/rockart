<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%culture}}`.
 */
class m190212_091921_create_culture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('culture', [
            'id' => $this->primaryKey(),
        ]);

        $this->createTable('culture_language', [
            'id' => $this->primaryKey(),
            'culture_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-culture_language-culture',
            'culture_language',
            'culture_id',
            'culture',
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
            'fk-culture_language-culture',
            'culture_language'
        );

        $this->dropTable('culture_language');

        $this->dropTable('culture');
    }
}
