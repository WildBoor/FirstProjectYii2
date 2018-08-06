<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Bill;
use common\models\Operation;


class AccountSearch extends User
{
    public function rules()
    {

        return [
            [['username'], 'trim'],
            //[['email'], 'email'],
            //[['amount'], 'number'],
            //[['created_at'],'number'],
            [['username','email'],'trim',],
            [['username','email'],'exist', 'message' => 'Совпадений не найдено'],
        ];
    }

    public function scenarios()
    {

        return Model::scenarios();
    }

    public function search($params)
    {
        $role = User::findOne(Yii::$app->user->id)->role;

        if($role !== 1)
        {
            $query = Operation::find()
                ->where(['email_from' => Yii::$app->user->identity->email])
                ->orWhere(['email_to' => Yii::$app->user->identity->email]);
        } else {
            $query = User::find()->where('user_id>1');
        }

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' =>
                    [
                    'pageSize' => 5,
                    ],
            ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'username' => $this->username,
            'email' => $this->email,
            'amount' => User::findByEmail($this->email)->bill->amount,
           'created_at' => $this->created_at,
           ]);

        $query->andFilterWhere(['like','username', $this->username])
              ->andFilterWhere(['like', 'email', $this->email]);
        
        return $dataProvider;
    }
}