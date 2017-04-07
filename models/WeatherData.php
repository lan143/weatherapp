<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "weather_data".
 *
 * @property int $id
 * @property int $city_id
 * @property int $date
 * @property int $temp
 */
class WeatherData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weather_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'date', 'temp'], 'required'],
            [['city_id', 'date'], 'integer'],
            ['temp', 'double'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'date' => 'Date',
            'temp' => 'Temp',
        ];
    }
}
