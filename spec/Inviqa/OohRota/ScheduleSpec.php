<?php

namespace spec\Inviqa\OohRota;

use Inviqa\OohRota\User\Engineer;
use Inviqa\OohRota\TimePeriod\Month;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScheduleSpec extends ObjectBehavior
{
    function it_should_return_the_engineers_allocated_to_this_month(Engineer $engineer, Month $month)
    {
        $this->beConstructedWith([$engineer], $month);
        $this->getAllocatedEngineers()->shouldReturn([$engineer]);
    }

    function it_should_return_the_month_of_the_schedule(Month $month)
    {
        $this->beConstructedWith([], $month);
        $this->getMonth()->shouldReturn($month);
    }
}
