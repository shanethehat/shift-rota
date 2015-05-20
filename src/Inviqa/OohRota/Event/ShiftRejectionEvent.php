<?php

namespace Inviqa\OohRota\Event;

use Inviqa\OohRota\Shift;
use Inviqa\OohRota\User\Engineer;

class ShiftRejectionEvent extends OohEvent
{
    /**
     * @var Shift
     */
    private $shift;
    /**
     * @var Engineer
     */
    private $engineer;

    /**
     * @param Shift $shift
     * @param Engineer $engineer
     */
    public function __construct(Shift $shift, Engineer $engineer)
    {

        $this->shift = $shift;
        $this->engineer = $engineer;
    }

    /**
     * @return \DateTime
     */
    public function getShiftDate()
    {
        return $this->shift->getDate();
    }

    /**
     * @return Engineer
     */
    public function getEngineer()
    {
        return $this->engineer;
    }
}
