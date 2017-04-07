<?php
namespace tests\calendar;

use app\calendar\Calendar;

class CalendarTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testGenerateDays()
    {
        $calendar = new Calendar();

        $days = $calendar->generateDays(strtotime('2017-01-01'), strtotime('2017-01-31'));

        $this->assertCount(31, $days);

        $this->assertTrue($days['2017.01.01']['first_day']);
    }

    public function testConvertDate()
    {
        $calendar = new Calendar();

        $this->assertTrue($calendar->convertDate('2017-01-01') == 1483228800);
        $this->assertTrue($calendar->convertDate(1483228800) == 1483228800);

        $this->expectException(\InvalidArgumentException::class);
        $calendar->convertDate(0);

        $this->expectException(\InvalidArgumentException::class);
        $calendar->convertDate('0000-01-01');
    }
}