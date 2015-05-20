<?php

namespace Inviqa\OohRota\TimePeriod;


interface Month
{
    /**
     * @return Day[]
     */
    public function getDays();
}
