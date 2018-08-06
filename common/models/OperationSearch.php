<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Operation;


class OperationSearch extends Operation
{
    public function rules()
    {

        return [
            [['email_to','email_from','transfer_amount','created_at'], 'trim'],
            [['email_to','email_from','transfer_amount','created_at'], 'exist',
            'message' => 'Совпадений не найдено'],
        ];
    }
    
    public function scenarios()
    {

        return Model::scenarios();
    }

    public function search($params)
    {

        $query = Operation::find()
            ->where(['email_from' => Yii::$app->user->identity->email])
            ->orWhere(['email_to' => Yii::$app->user->identity->email]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => 
                [
                'pageSize' => 5,
                ],
        ]);

        if (!($this->load($params) && $this->validate())) 
        {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'email_from' => $this->email_from,
            'email_to' => $this->email_to,
            'transfer_amount' => $this->transfer_amount,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like','email_from', $this->email_from])
              ->andFilterWhere(['like', 'email_to', $this->email_to])
              ->andFilterWhere(['=', 'transfer_amount', $this->transfer_amount])
              ->andFilterWhere(['=', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}