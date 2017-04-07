<?php
namespace app\calendar;

class Calendar
{
    public function generateDays($from, $to)
    {
        $days = [];
        $start = $from;

        for ($next = $start; $start <= $to; $start = $next = strtotime('+1 day', $next))
        {
            $days[date('Y.m.d', $start)] = [
                'first_day' => date('d', $start) == 1,
                'unix_time' => $start
            ];
        }

        return $days;
    }

    public function convertDate($date)
    {
        if (is_numeric($date))
        {
            if ($date < 1)
                throw new \InvalidArgumentException("Unix time must be more 0");

            return $date;
        }
        else if (is_string($date))
        {
            $date = strtotime($date);
            return $this->convertDate($date);
        }
    }
}