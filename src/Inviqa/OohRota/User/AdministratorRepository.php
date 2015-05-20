<?php

namespace Inviqa\OohRota\User;

final class AdministratorRepository extends DoctrineUserRepository implements UserRepository
{
    /**
     * @var string
     */
    protected $entityClassName = 'Inviqa\OohRota\User\Administrator';
}
