<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $name
 * @property int $postal_code
 * @property string $country_code
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'postal_code', 'country_code'], 'required'],
            [['postal_code'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['country_code'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'postal_code' => 'Postal Code',
            'country_code' => 'Country Code',
        ];
    }
}
