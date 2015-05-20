<?php

namespace Inviqa\OohRota\User;


use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Inviqa\OohRota\Exception\RepositoryDefinitionException;

abstract class DoctrineUserRepository implements UserRepository
{
    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * @var string
     */
    protected $entityClassName;

    public function __construct(EntityManagerInterface $entityManager)
    {
        if (null == $this->entityClassName) {
            throw new RepositoryDefinitionException('Concrete Doctrine repository must define an entityClassName');
        }
        $this->repository = $entityManager->getRepository($this->entityClassName);
    }

    /**
     * @return Administrator[]
     */
    public function fetchAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param String $name
     * @return Administrator
     */
    public function findByName($name)
    {
        return $this->repository->findOneBy(['name' => $name]);
    }
}
