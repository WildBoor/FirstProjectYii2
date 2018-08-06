<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180802_202017_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'user_id' => $this->primaryKey(),
            'role' => $this->integer()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);

        $this->insert('user', [
            'role' => 1,
            'username' => 'Админ',
           // 'auth_key' => '',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            //'password_reset_token' => '',
            'email' => 'admin@mail.ru',
           // 'created_at' => dateTime(),
            //'updated_at' => dateTime(),
        ]);

    //     При добавлении внешнего ключа
    //Тип поля внешнего ключа должен совпадать с типом связываемого с ним поля
   //Закоментировал внешний ключ,так как связывал таблицы через ActiveRecord

//        $this->addForeignKey(
//            'fk_user_id',// это "условное имя" ключа
//            'user',// это название текущей таблицы
//            'uaser_id',// это имя поля в текущей таблице, которое будет ключом
//            'bill',// это имя таблицы, с которой хотим связаться
//            'id',// это поле таблицы, с которым хотим связаться
//            'CASCADE'
//        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

//        $this->dropForeignKey(
//            'fk_user_id',
//            'user'
//        );


        $this->dropTable('user');
    }
}
