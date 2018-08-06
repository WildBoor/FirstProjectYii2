<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bill`.
 */
class m180802_201744_create_bill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bill', [
            'id' => $this->primaryKey(),
            'bill' => $this->string()->notNull(),
            'amount' => $this->float()->notNull(),
        ]);

        $this->insert('bill', [
           // 'id' => 1,
            'bill' => 'Счёт админа',
            'amount' => 100000,
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropTable('bill');
    }
}
