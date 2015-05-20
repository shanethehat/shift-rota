<?php

namespace spec\Inviqa\OohRota;

use Inviqa\OohRota\User\Engineer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShiftSpec extends ObjectBehavior
{
    function let(\DateTime $date)
    {
        $this->beConstructedWith($date);
    }

    function it_should_allow_an_engineer_to_be_assigned(Engineer $engineer)
    {
        $this->allocateEngineer($engineer);
        $this->getAllocatedEngineer()->shouldReturn($engineer);
    }

    function it_should_return_null_if_no_engineer_is_allocated()
    {
        $this->getAllocatedEngineer()->shouldReturn(null);
    }

    function it_should_return_null_if_an_engineer_is_unallocated(Engineer $engineer)
    {
        $this->allocateEngineer($engineer);
        $this->unallocateEngineer();
        $this->getAllocatedEngineer()->shouldReturn(null);
    }

    function it_should_throw_an_error_when_confirming_with_unallocated_engineer()
    {
        $this->shouldThrow('Inviqa\OohRota\Exception\NoEngineerException')->during('confirmEngineer', [true]);
    }

    function it_should_allow_an_allocated_engineer_to_be_confirmed(Engineer $engineer)
    {
        $this->allocateEngineer($engineer);
        $this->confirmEngineer(true);
        $this->isEngineerConfirmed()->shouldReturn(true);
    }

    function it_should_allow_a_confirmed_engineer_to_be_unconfirmed(Engineer $engineer)
    {
        $this->allocateEngineer($engineer);
        $this->confirmEngineer(true);
        $this->confirmEngineer(false);
        $this->isEngineerConfirmed()->shouldReturn(false);
    }

    function it_should_unconfirm_when_an_engineer_is_unallocated(Engineer $engineer)
    {
        $this->allocateEngineer($engineer);
        $this->confirmEngineer(true);
        $this->unallocateEngineer();
        $this->isEngineerConfirmed()->shouldReturn(false);
    }

    function it_should_return_the_date($date)
    {
        $this->getDate()->shouldReturn($date);
    }
}
