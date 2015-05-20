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
     * @ManyToMany(targetEntity="Inviqa\OohRota\User\Engineer")
     * @var Engineer[]
     */
    private $engineers;

    /**
     * @OneToMany(targetEntity="Inviqa\OohRota\Shift", mappedBy="schedule")
     * @var Shift[]
     */
    private $shifts;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    private $date;

    /**
     * @param \DateTime $date
     * @param Engineer[] $engineers
     * @param Shift[] $shifts
     */
    public function __construct(\DateTime $date, array $engineers, array $shifts)
    {
        $this->engineers = $engineers;
        $this->shifts = $shifts;
        $this->date = $date;
    }

    /**
     * @return Engineer[]
     */
    public function getAllocatedEngineers()
    {
        return $this->engineers;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->date->format('m');
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->date->format('Y');
    }
}
