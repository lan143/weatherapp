<?php
namespace app\commands;

use app\models\City;
use app\models\WeatherData;
use app\weather\WeatherComponent;
use Yii;
use yii\console\Controller;

class ParserController extends Controller
{
    public function actionIndex($from = '2016-01-01', $to = '')
    {
        if (strlen($to) == 0)
            $to = date('Y-m-d');

        /* @var City[] $cities */
        $cities = City::find()->all();

        /* @var WeatherComponent $weather_component */
        $weather_component = Yii::$app->weather;

        foreach ($cities as $city)
        {
            $data = $weather_component->historyByPostalCode($city->postal_code, $city->country_code,
                'hour', $from, $to);

            foreach ($data as $date => $sdata)
            {
                $wd = new WeatherData();
                $wd->city_id = $city->id;
                $wd->date = $date;
                $wd->temp = $sdata['temp'];
                if (!$wd->save())
                {
                    echo "Cant save history data. Errors: ".var_export($wd->getErrors(), true) . ' Data: ' . var_export($sdata) .  PHP_EOL;
                }
            }
        }

        return 0;
    }
}
