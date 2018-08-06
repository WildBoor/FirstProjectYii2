<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 06.08.2018
 * Time: 14:44
 */

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Operation;

class UserSearch extends User
{
    public function rules()
    {

        return [
            [['username','email','created_at'], 'trim'],
            [['username','email','created_at'], 'exist',
                'message' => 'Совпадений не найдено']
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
            $query = User::findByEmail(Yii::$app->user->identity->email);
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

        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like','username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['=', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}