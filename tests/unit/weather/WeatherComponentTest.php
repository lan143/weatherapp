<?php
namespace tests\calendar;

use Yii;

class WeatherComponentTest extends \Codeception\Test\Unit
{
    public function testHistoryByPostalCode()
    {
        $data = [];
        $test_data = Yii::$app->weather->historyByPostalCode('22222', 'US', 'hour', '2017-01-01T00:00:00+00:00', '2017-01-03T00:00:00+00:00');

        foreach ($test_data as $key => $td)
            $data[$key] = $td;

        $this->assertCount(49, $data);

        foreach ($data as $date => $d)
        {
            $this->assertNotEmpty($d['temp']);
        }
    }
}