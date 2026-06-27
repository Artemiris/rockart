<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%counter}}`.
 */
class m190327_092043_create_counter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%counter}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(50),
            'uri' => $this->string(),
            'user_agent' => $this->string(),

            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%counter}}');
    }
}
