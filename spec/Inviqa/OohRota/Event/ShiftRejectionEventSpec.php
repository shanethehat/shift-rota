<?php

namespace spec\Inviqa\OohRota\Event;

use Inviqa\OohRota\Shift;
use Inviqa\OohRota\User\Engineer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShiftRejectionEventSpec extends ObjectBehavior
{
    function it_is_an_event()
    {
        $this->shouldHaveType('Inviqa\OohRota\Event\OohEvent');
    }

    function let(Shift $shift, Engineer $engineer)
    {
        $this->beConstructedWith($shift, $engineer);
    }

    function it_should_return_the_rejecting_engineer($engineer)
    {
        $this->getEngineer()->shouldReturn($engineer);
    }

    function it_should_return_the_date_of_The_shift($shift, \DateTime $date)
    {
        $shift->getDate()->willReturn($date);
        $this->getShiftDate()->shouldReturn($date);
    }
}
