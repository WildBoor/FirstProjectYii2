<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 21.03.2018
 * Time: 15:15
 */

namespace common\models;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\db\Expression;
use yii\db\ActiveRecord;

class Operation extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    

    public static function tableName()
    {
        return 'operation';
    }
    
}