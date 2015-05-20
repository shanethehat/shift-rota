<?php

namespace spec\Inviqa\OohRota\Service;

use Inviqa\OohRota\Event\OohEvents;
use Inviqa\OohRota\Exception\WrongEngineerException;
use Inviqa\OohRota\Shift;
use Inviqa\OohRota\User\Engineer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ShiftServiceSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($dispatcher);
    }

    function it_should_allocate_an_engineer_to_a_shift(Shift $shift, Engineer $engineer)
    {
        $shift->allocateEngineer($engineer)->shouldBeCalled();
        $this->allocateEngineerToShift($engineer, $shift);
    }

    function it_should_remove_an_engineer_from_a_shift(Shift $shift)
    {
        $shift->unallocateEngineer()->shouldBeCalled();
        $this->removeEngineerFromShift($shift);
    }

    function it_confirms_an_engineer_on_a_shift(Shift $shift, Engineer $engineer)
    {
        $shift->getAllocatedEngineer()->willReturn($engineer);
        $shift->confirmEngineer(true)->shouldBeCalled();
        $this->confirmEngineerOnShift($engineer, $shift);
    }

    function it_does_not_confirm_an_unallocated_engineer(Shift $shift, Engineer $engineer1, Engineer $engineer2)
    {
        $shift->getAllocatedEngineer()->willReturn($engineer2);
        $this->shouldThrow(
            new WrongEngineerException('Cannot confirm engineer on shift, another engineer is allocated')
        )->during('confirmEngineerOnShift', [$engineer1, $shift]);
    }

    function it_should_remove_a_confirmation(Shift $shift)
    {
        $shift->confirmEngineer(false)->shouldBeCalled();
        $shift->isEngineerConfirmed()->willReturn(true);
        $this->unconfirmEngineerFromShift($shift);
    }

    function it_should_dispatch_an_event_when_an_engineer_confirms($dispatcher, Engineer $engineer, Shift $shift)
    {
        $dispatcher->dispatch(
            OohEvents::ENGINEER_CONFIRMS,
            Argument::type('Inviqa\OohRota\Event\ShiftConfirmationEvent')
        )->shouldBeCalled();

        $shift->getAllocatedEngineer()->willReturn($engineer);
        $shift->confirmEngineer(true)->shouldBeCalled();
        $this->confirmEngineerOnShift($engineer, $shift);
    }

    function it_should_not_dispatch_an_event_when_no_engineer_is_confirmed($dispatcher, Shift $shift)
    {
        $dispatcher->dispatch(
            OohEvents::ENGINEER_CONFIRMS,
            Argument::type('Inviqa\OohRota\Event\ShiftConfirmationEvent')
        )->shouldNotBeCalled();


        $shift->isEngineerConfirmed()->willReturn(false);
        $this->unconfirmEngineerFromShift($shift);
    }

    function it_should_allow_an_engineer_to_reject_a_shift(Engineer $engineer, Shift $shift)
    {
        $shift->unallocateEngineer()->shouldBeCalled();
        $this->engineerRejectShift($engineer, $shift);
    }

    function it_should_dispatch_en_event_if_the_engineer_rejects_a_shift(Engineer $engineer, Shift $shift, $dispatcher)
    {
        $dispatcher->dispatch(
            OohEvents::ENGINEER_REJECTS,
            Argument::type('Inviqa\OohRota\Event\ShiftRejectionEvent')
        )->shouldBeCalled();

        $this->engineerRejectShift($engineer, $shift);
    }
}
