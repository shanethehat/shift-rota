<?php

namespace Inviqa\OohRota\Shift;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Inviqa\OohRota\Shift;

class DoctrineShiftRepository implements ShiftRepository
{
    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository('Inviqa\OohRota\Shift');
    }

    /**
     * @param \DateTime $date
     * @return Shift
     */
    public function findShiftByDate(\DateTime $date)
    {
        return $this->repository->findOneBy(['date' => $date]);
    }
}
