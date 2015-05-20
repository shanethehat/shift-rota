<?php

namespace spec\Inviqa\OohRota\TimePeriod;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MonthSpec extends ObjectBehavior
{
    function it_should_be_a_month()
    {
        $this->shouldImplement('Inviqa\OohRota\TimePeriod\Month');
    }
}
