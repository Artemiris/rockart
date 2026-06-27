<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%epoch}}`.
 */
class m190212_091922_create_epoch_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('epoch', [
            'id' => $this->primaryKey(),
        ]);

        $this->createTable('epoch_language', [
            'id' => $this->primaryKey(),
            'epoch_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-epoch_language-epoch',
            'epoch_language',
            'epoch_id',
            'epoch',
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
            'fk-epoch_language-epoch',
            'epoch_language'
        );

        $this->dropTable('epoch_language');

        $this->dropTable('epoch');
    }
}
