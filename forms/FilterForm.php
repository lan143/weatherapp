<?php
namespace app\forms;

use app\models\City;
use yii\base\Model;

class FilterForm extends Model
{
    public $city_id;
    public $from;
    public $to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            ['city_id', 'in', 'range' => City::find()->select('id')->asArray()->column()],
            [['from', 'to'], 'match', 'pattern' => "/[0-9]{2}.[0-9]{4}/", 'message' => 'Неверный формат даты'],
            [['from', 'to', 'city_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!$this->from)
            $this->from = date('m.Y', strtotime('-2 month'));

        if (!$this->to)
            $this->to = date('m.Y');

        if (!$this->city_id)
            if ($city = City::find()->one())
                $this->city_id = $city->id;
    }

    public function getUnixFrom()
    {
        return strtotime('01.' . $this->from);
    }

    public function getUnixTo()
    {
        return strtotime(date('t', strtotime('01.' . $this->to)) . '.' . $this->to . ' 23:59:59');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => 'Город',
            'from' => 'С',
            'to' => 'По',
        ];
    }
}