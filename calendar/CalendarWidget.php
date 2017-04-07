<?php
namespace app\calendar;

use yii\base\Widget;

class CalendarWidget extends Widget
{
    public $from;
    public $to;
    public $data;

    private $calendar;

    const WEEK_DAYS = [
        'пн',
        'вт',
        'ср',
        'чт',
        'пт',
        'сб',
        'вс',
    ];

    public function init()
    {
        parent::init();

        foreach ($this->data as $day_data)
        {
            if (!($day_data instanceof ElementInterface))
                throw new \InvalidArgumentException('All day data elements must be instance of ElementInterface');
        }

        $this->calendar = new Calendar();

        $this->from = $this->calendar->convertDate($this->from);
        $this->to = $this->calendar->convertDate($this->to);
    }

    public function run()
    {
        parent::run();

        $days = $this->calendar->generateDays($this->from, $this->to);

        return $this->render('calendar', [
            'days' => $days,
            'data' => $this->data
        ]);
    }
}