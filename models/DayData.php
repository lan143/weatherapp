<?php
namespace app\models;

use app\calendar\ElementInterface;
use yii\base\Object;

class DayData extends Object implements ElementInterface
{
    public $date;
    public $night_temp;
    public $daytime_temp;
    public $class = array();

    public function getText()
    {
        $result = '';

        if ($this->night_temp !== null && $this->daytime_temp !== null)
        {
            if ($this->night_temp > 0)
                $result .= '+';

            $result .= $this->night_temp . ' / ';

            if ($this->daytime_temp > 0)
                $result .= '+';

            $result .= $this->daytime_temp;
        }

        return $result;
    }

    public function getClass()
    {
        return $this->class;
    }
}