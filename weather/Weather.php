<?php
namespace app\weather;

use app\models\DayData;

class Weather
{
    public function generateData($data)
    {
        $days_data = $this->normalizeData($data);
        $days_data = $this->findMaximum($days_data);

        return $days_data;
    }

    private function normalizeData($data)
    {
        $days_data = [];

        foreach ($data as $_data)
        {
            if (!isset($days_data[$_data['date']]))
                $days_data[$_data['date']] = new DayData();

            if ($_data['night'] == 1)
                $days_data[$_data['date']]->night_temp = $_data['temp'];
            else
                $days_data[$_data['date']]->daytime_temp = $_data['temp'];
        }

        return $days_data;
    }

    private function findMaximum($days_data)
    {
        $maximum = [];

        foreach ($days_data as $date => &$day_data)
        {
            if ($day_data->night_temp !== null && $day_data->daytime_temp !== null)
            {
                if ($day_data->daytime_temp > $day_data->night_temp)
                    $diff = $day_data->daytime_temp - $day_data->night_temp;
                else
                    $diff = $day_data->night_temp - $day_data->daytime_temp;

                if (!isset($maximum[date('Y.m', strtotime($date))]) || $maximum[date('Y.m', strtotime($date))]['value'] < $diff)
                    $maximum[date('Y.m', strtotime($date))] = [
                        'value' => $diff,
                        'date' => $date,
                    ];

                if (!isset($maximum[date('Y/W', strtotime($date))]) || $maximum[date('Y/W', strtotime($date))]['value'] < $diff)
                    $maximum[date('Y/W', strtotime($date))] = [
                        'value' => $diff,
                        'date' => $date,
                    ];
            }
        }

        foreach ($days_data as $date => &$day_data)
        {
            if (isset($maximum[date('Y.m', strtotime($date))]) && $date == $maximum[date('Y.m', strtotime($date))]['date'])
                $day_data->class[] = 'max_in_month';

            if (isset($maximum[date('Y/W', strtotime($date))]) && $date == $maximum[date('Y/W', strtotime($date))]['date'])
                $day_data->class[] = 'max_in_week';
        }

        return $days_data;
    }
}