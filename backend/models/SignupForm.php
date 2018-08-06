<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\Bill;
 

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $bill;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'bill' => 'Ваш счёт',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким именем уже существует'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Данный email занят'],

            ['bill', 'required'],
            ['bill', 'trim'],
            ['bill', 'string', 'min' => 3,'max' => 20],
            ['bill', 'unique','targetClass' => '\common\models\Bill', 'message' => 'Данный счёт занят другим пользователем'],
            
            ['password', 'required'],
            ['password', 'string', 'min' => 3],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();                       //Создаём экземпляр класса
        $user->username = $this->username;        //Записываем имя пользователя
        $user->email = $this->email;              //Записываем email
        $user->setPassword($this->password);      //Записываем хеш пароля в БД
        $user->save() ? $user : null;             //Сохраняем

        $bill = new Bill();
        $bill->bill = $this->bill;                //Название счёта
        $bill->amount = 0;                        //Начальная сумма на счёте пользователя при регистрации
        $bill->save() ? $bill : null;             //Сохраняем
       
    }
}
