<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 22.03.2018
 * Time: 21:16
 */

namespace common\models;

use yii\base\Model;
use common\models\User;
use common\models\Bill;
use common\models\Operation;

class OperationForm extends Model
{
    public $email_to;
    public $transfer_amount;

    public function attributeLabels()
    {
        return [
            'email_to' => 'Email получателя',
            'transfer_amount' => 'Сумма перевода',
        ];
    }


    public function rules()
    {

        return [
            [['email_to', 'transfer_amount'], 'required'],
            [['email_to'], 'email','message' => 'Неправильно введён email'],
            ['email_to', 'compare', 'compareValue' => \Yii::$app->user->identity->email,
                'operator' => '!=', 'message' => 'Вы не можете отправлять себе деньги'],
//            ['email_to', 'unique', 'targetClass' => 'common\models\User', 'targetAttribute' => 'email',
//                'message' => 'Пользователя с таким email не существует'],

            [['transfer_amount'], 'compare',
                'compareValue' => Bill::findOne(\Yii::$app->user->id)->amount,
                'operator' => '<=',
                'message' => 'На вашем счёте недостаточно средств для перевода'],
        ];
    }

     
    public function operation()
    {
        if (!$this->validate()) {
            return null;
        }

        $operation = new Operation();
        $sender =  Bill::findOne(\Yii::$app->user->id);
        $recipient = User::findByEmail(['email' => $this->email_to])->bill;

        $sender->amount = ($sender->amount) - ($this->transfer_amount);
        $sender->save();
        $recipient->amount = ($recipient->amount) + ($this->transfer_amount);
        $recipient->save();

        $operation->email_from = \Yii::$app->user->identity->email;
        $operation->email_to = $this->email_to;
        $operation->transfer_amount = $this->transfer_amount;
        $operation->save();

    }
    
}