<?php

namespace Inviqa\OohRota\Event;

use Inviqa\OohRota\User\Engineer;
use Inviqa\OohRota\Shift;

class ShiftConfirmationEvent extends OohEvent
{
    /**
     * @var Shift
     */
    private $shift;

    /**
     * @param Shift $shift
     */
    public function __construct(Shift $shift)
    {
        $this->shift = $shift;
    }

    /**
     * @return bool
     */
    public function isEngineerConfirmed()
    {
        return $this->shift->isEngineerConfirmed();
    }

    /**
     * @return Engineer
     */
    public function getShiftEngineer()
    {
        return $this->shift->getAllocatedEngineer();
    }

    /**
     * @return \DateTime
     */
    public function getShiftDate()
    {
        return $this->shift->getDate();
    }
}
