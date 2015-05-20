<?php

namespace Inviqa\OohRota\Service;

use Inviqa\OohRota\Event\OohEvents;
use Inviqa\OohRota\Event\ShiftConfirmationEvent;
use Inviqa\OohRota\Event\ShiftRejectionEvent;
use Inviqa\OohRota\Exception\WrongEngineerException;
use Inviqa\OohRota\Shift;
use Inviqa\OohRota\User\Engineer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ShiftService
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function allocateEngineerToShift(Engineer $engineer, Shift $shift)
    {
        $shift->allocateEngineer($engineer);
    }

    public function removeEngineerFromShift(Shift $shift)
    {
        $shift->unallocateEngineer();
    }

    public function confirmEngineerOnShift(Engineer $engineer, Shift $shift)
    {
        if ($shift->getAllocatedEngineer() != $engineer) {
            throw new WrongEngineerException('Cannot confirm engineer on shift, another engineer is allocated');
        }
        $shift->confirmEngineer(true);

        $event = new ShiftConfirmationEvent($shift);
        $this->dispatcher->dispatch(OohEvents::ENGINEER_CONFIRMS, $event);
    }

    public function unconfirmEngineerFromShift(Shift $shift)
    {
        if (!$shift->isEngineerConfirmed()) {
            return;
        }
        $shift->confirmEngineer(false);
    }



    public function engineerRejectShift(Engineer $engineer, Shift $shift)
    {
        $shift->unallocateEngineer();

        $event = new ShiftRejectionEvent($shift, $engineer);
        $this->dispatcher->dispatch(OohEvents::ENGINEER_REJECTS, $event);
    }
}
