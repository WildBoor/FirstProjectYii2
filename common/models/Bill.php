<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 26.03.2018
 * Time: 1:04
 */

namespace common\models;


use yii\db\ActiveRecord;

class Bill extends ActiveRecord
{

    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id'])->inverseOf('bill');//Связь с таблицей user
                                                                                        // один к одному
    }

    public static function tableName()
    {
        return '{{%bill}}';
    }
}