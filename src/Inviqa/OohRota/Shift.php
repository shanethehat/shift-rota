<?php

namespace Inviqa\OohRota;

use Inviqa\OohRota\Exception\NoEngineerException;
use Inviqa\OohRota\User\Engineer;

/**
 * @Entity @Table(name="shifts")
 */
class Shift
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /**
     * @ManyToOne(targetEntity="Inviqa\OohRota\User\Engineer")
     * @var Engineer
     */
    protected $engineer;

    /**
     * @Column(type="boolean")
     * @var bool
     */
    protected $confirmed = false;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $date;

    /**
     * @ManyToOne(targetEntity="Inviqa\OohRota\Schedule", inversedBy="shifts")
     * @var Schedule
     */
    protected $schedule;

    /**
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @param Engineer $engineer
     */
    public function allocateEngineer(Engineer $engineer)
    {
        $this->engineer = $engineer;
    }

    /**
     *
     */
    public function unallocateEngineer()
    {
        $this->engineer = null;
        $this->confirmed = false;
    }

    /**
     * @return Engineer
     */
    public function getAllocatedEngineer()
    {
        return $this->engineer;
    }

    /**
     * @param bool $confirmed
     * @throws NoEngineerException
     */
    public function confirmEngineer($confirmed)
    {
        if (null == $this->engineer) {
            throw new NoEngineerException('The shift has no allocated engineer');
        }

        $this->confirmed = $confirmed;
    }

    /**
     * @return bool
     */
    public function isEngineerConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
