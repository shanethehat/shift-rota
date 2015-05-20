<?php

namespace Inviqa\OohRota\Shift;

use Inviqa\OohRota\Shift;

interface ShiftRepository
{
    /**
     * @param \DateTime $date
     * @return Shift
     */
    public function findShiftByDate(\DateTime $date);
}
