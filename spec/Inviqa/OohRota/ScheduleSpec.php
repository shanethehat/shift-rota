<?php

namespace spec\Inviqa\OohRota;

use Inviqa\OohRota\Shift;
use Inviqa\OohRota\User\Engineer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScheduleSpec extends ObjectBehavior
{
    function let(\DateTime $date, Engineer $engineer, Shift $shift)
    {
        $this->beConstructedWith($date, [$engineer], [$shift]);
    }

    function it_should_return_the_engineers_allocated_to_this_month($engineer)
    {
        $this->getAllocatedEngineers()->shouldReturn([$engineer]);
    }

    function it_should_return_the_month_of_the_schedule($date)
    {
        $date->format('m')->willReturn('05');
        $this->getMonth()->shouldReturn('05');
    }

    function it_should_return_the_year_of_the_schedule($date)
    {
        $date->format('Y')->willReturn('2015');
        $this->getYear()->shouldReturn('2015');
    }
}
