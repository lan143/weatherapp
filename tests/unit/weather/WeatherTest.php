<?php
namespace tests\calendar;

use app\helpers\TestHelper;
use app\models\DayData;
use app\weather\Weather;

class WeatherTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testNormalizeData()
    {
        $weather = new Weather();

        $test_data = [];

        for ($i = 1; $i < 10; $i++)
        {
            $test_data[] = [
                'date' => '2017-01-0'.$i,
                'temp' => rand(-40, 40),
                'night' => 1,
            ];

            $test_data[] = [
                'date' => '2017-01-0'.$i,
                'temp' => rand(-40, 40),
                'night' => 0,
            ];
        }

        $data = TestHelper::getMethod($weather, 'normalizeData', ['data' => $test_data]);

        $this->assertTrue(is_array($data));

        $this->assertCount(9, $data);

        foreach ($data as $key => $day)
        {
            $this->assertTrue(strtotime($key) > 0);
            $this->assertTrue($day instanceof DayData);

            foreach ($test_data as $td)
            {
                if ($td['date'] == $key)
                {
                    if ($td['night'] == 1)
                        $this->assertTrue($day->night_temp == $td['temp']);
                    else if ($td['night'] == 0)
                        $this->assertTrue($day->daytime_temp == $td['temp']);
                }
            }
        }
    }

    public function testFindMaximum()
    {
        $test_data = [];

        for ($i = 1; $i <= 31; $i++)
        {
            $key = '2017-01-' . ($i < 10 ? '0' . $i : $i);
            $test_data[$key] = new DayData();
            $test_data[$key]->date = $key;
            $test_data[$key]->night_temp = rand(-40, 40);
            $test_data[$key]->daytime_temp = rand(-40, 40);
        }

        $weather = new Weather();
        $data = TestHelper::getMethod($weather, 'findMaximum', ['days_data' => $test_data]);

        $this->assertTrue(is_array($data));
        $this->assertCount(31, $data);

        $max_in_month_count = 0;
        $max_in_week_count = 0;

        foreach ($data as $key => $day)
        {
            $this->assertTrue(strtotime($key) > 0);
            $this->assertTrue($day instanceof DayData);

            if (in_array('max_in_month', $day->class))
                $max_in_month_count++;

            if (in_array('max_in_week', $day->class))
                $max_in_week_count++;
        }

        $this->assertTrue($max_in_month_count == 1);
        $this->assertTrue($max_in_week_count == 6);
    }
}