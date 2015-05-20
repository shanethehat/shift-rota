<?php

namespace Inviqa\OohRota;

use Inviqa\OohRota\TimePeriod\Month;
use Inviqa\OohRota\User\Engineer;

/**
 * @Entity @Table(name="schedules")
 **/
class Schedule
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /**
     * @var Engineer[]
     */
    private $engineers;

    /**
     * @var Month
     */
    private $month;

    /**
     * @param Engineer[] $engineers
     * @param Month $month
     */
    public function __construct(array $engineers, Month $month)
    {
        $this->engineers = $engineers;
        $this->month = $month;
    }

    /**
     * @return Engineer[]
     */
    public function getAllocatedEngineers()
    {
        return $this->engineers;
    }

    /**
     * @return Month
     */
    public function getMonth()
    {
        return $this->month;
    }
}
