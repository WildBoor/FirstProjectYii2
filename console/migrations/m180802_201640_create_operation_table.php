<?php

use yii\db\Migration;

/**
 * Handles the creation of table `operation`.
 */
class m180802_201640_create_operation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('operation', [
            'id' => $this->primaryKey(),
            'email_from' => $this->string()->notNull(),
            'email_to' => $this->string()->notNull(),
            'transfer_amount' => $this->float()->notNull(),
            'created_at' => $this->dateTime(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('operation');
    }
}
