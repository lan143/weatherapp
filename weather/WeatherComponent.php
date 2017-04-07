<?php
namespace app\weather;

use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class WeatherComponent
 * @package app\weather
 *
 * @property string $access_token
 * @property Api $api
 */
class WeatherComponent extends Component
{
    public $access_token;
    public $timeout = 6;
    private $api;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (strlen($this->access_token) == 0)
            throw new InvalidConfigException('You need set access token');

        $this->api = new Api($this->access_token);
    }

    /**
     * Return history weather data in period for city by postal code
     *
     * @param $postal_code
     * @param $country
     * @param $period
     * @param $from
     * @param $to
     * @param array $fields
     * @return \Generator
     */
    public function historyByPostalCode($postal_code, $country, $period, $from, $to, $fields = ['temp'])
    {
        $intervals = [];
        $start = strtotime($from);
        $to = strtotime($to);

        switch ($period)
        {
            case 'hour':
                $step = '+1 hour';
                break;
            case 'day':
                $step = '+1 day';
                break;
        }

        for ($next = $start; $start <= $to; $start = $next)
        {
            $next = strtotime($step, $next);
            $intervals[] = date($start);
        }

        $offset = 0;

        while ($offset < count($intervals))
        {
            $vals = array_slice($intervals, $offset, 25);
            $start = date(\DateTime::ATOM, $vals[0]);
            $end = date(\DateTime::ATOM, end($vals));

            $data = $this->api->query('history_by_postal_code', 'json', [
                'period' => $period,
                'postal_code_eq' => $postal_code,
                'country_eq' => $country,
                'timestamp_between' => implode(',', [$start, $end]),
                'fields' => implode(',',$fields),
                'limit' => 25,
            ]);

            foreach ($vals as $key => $val)
            {
                yield $val => isset($data[$key]) ? $data[$key] : null;
            }

            if ($this->timeout > 0)
                sleep($this->timeout);

            $offset += count($vals);
        }
    }
}