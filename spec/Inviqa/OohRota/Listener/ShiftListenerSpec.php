<?php

namespace spec\Inviqa\OohRota\Listener;

use Inviqa\OohRota\Event\ShiftConfirmationEvent;
use Inviqa\OohRota\Event\ShiftRejectionEvent;
use Inviqa\OohRota\Notifier\Notifier;
use Inviqa\OohRota\User\Administrator;
use Inviqa\OohRota\User\Engineer;
use Inviqa\OohRota\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShiftListenerSpec extends ObjectBehavior
{
    function let(Notifier $notifier, UserRepository $adminRepository)
    {
        $this->beConstructedWith($notifier, $adminRepository);
    }

    function it_is_an_event_subscriber()
    {
        $this->shouldImplement('Inviqa\OohRota\Listener\EventSubscriber');
    }

    function it_should_notify_an_admin_if_the_engineer_rejects_the_shift($notifier, ShiftRejectionEvent $event,
            $adminRepository, Administrator $admin, Engineer $engineer, \DateTime $date)
    {
        $adminRepository->fetchAll()->willReturn([$admin]);
        $engineer->getName()->willReturn('Bob');
        $date->format('Y-m-d')->willReturn('2015-05-19');
        $event->getEngineer()->willReturn($engineer);
        $event->getShiftDate()->willReturn($date);
        $notifier->notify($admin, 'Bob has rejected the allocated shift 2015-05-19')->shouldBeCalled();
        $this->onEngineerRejectsShift($event);
    }
}
