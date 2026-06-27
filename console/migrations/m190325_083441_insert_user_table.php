<?php

use yii\db\Migration;

/**
 * Class m190325_083441_insert_user_table
 */
class m190325_083441_insert_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('auth_item', [
            'name' => 'admin',
            'type' => 1,
            'description' => 'Администратор',
            'rule_name' => null,
            'data' => null,
            'created_at' => strtotime('now'),
            'updated_at' => strtotime('now'),
        ]);

        $this->insert('user', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => 'lPCobw-_gBfqhYDRe6k2opMNVkHzAfyE',
            'password_hash' => '$2y$13$ADHuRGOZge05SyNSw7nDquVsv870ieI97MmbMyzZJMFrGNXKW9ZiS',
            'password_reset_token' => null,
            'email' => 'mirrorlab.artemir@gmail.com',
            'status' => 10,
            'created_at' => strtotime('now'),
            'updated_at' => strtotime('now'),
        ]);

        $this->insert('auth_assignment', [
            'item_name' => 'admin',
            'user_id' => 1,
            'created_at' => strtotime('now'),
        ]);

        $this->insert('auth_item', [
            'name' => 'manager',
            'type' => 1,
            'description' => 'Контент-менеджер',
            'rule_name' => null,
            'data' => null,
            'created_at' => strtotime('now'),
            'updated_at' => strtotime('now'),
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'admin',
            'child' => 'manager',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('auth_item_child', [
            'parent' => 'admin',
            'child' => 'manager',
        ]);


        $this->delete('auth_item', [
            'name' => 'manager',
            'type' => 1,
            'description' => 'Контент-менеджер',
            'rule_name' => null,
            'data' => null,
        ]);

        $this->delete('auth_assignment', [
            'item_name' => 'admin',
            'user_id' => 1,
        ]);

        $this->delete('user', [
            'id' => 1,
            'username' => 'admin',
        ]);

        $this->delete('auth_item', [
            'name' => 'admin',
            'type' => 1,
            'description' => 'Администратор',
            'rule_name' => null,
            'data' => null,
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190325_083441_insert_user_table cannot be reverted.\n";

        return false;
    }
    */
}
