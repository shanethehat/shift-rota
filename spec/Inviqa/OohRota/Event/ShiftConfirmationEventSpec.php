<?php

namespace spec\Inviqa\OohRota\Event;

use Inviqa\OohRota\User\Engineer;
use Inviqa\OohRota\Shift;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShiftConfirmationEventSpec extends ObjectBehavior
{
    function it_is_an_event()
    {
        $this->shouldHaveType('Inviqa\OohRota\Event\OohEvent');
    }

    function let(Shift $shift)
    {
        $this->beConstructedWith($shift);
    }

    function it_should_show_that_the_shift_has_been_confirmed($shift)
    {
        $shift->isEngineerConfirmed()->willReturn(true);
        $this->isEngineerConfirmed()->shouldReturn(true);
    }

    function it_should_return_the_allocated_engineer($shift, Engineer $engineer)
    {
        $shift->getAllocatedEngineer()->willReturn($engineer);
        $this->getShiftEngineer()->shouldReturn($engineer);
    }

    function it_should_return_the_date_of_The_shift($shift, \DateTime $date)
    {
        $shift->getDate()->willReturn($date);
        $this->getShiftDate()->shouldReturn($date);
    }
}
