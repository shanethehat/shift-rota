<?php

namespace Inviqa\OohRota\User;

final class EngineerRepository extends DoctrineUserRepository implements UserRepository
{
    /**
     * @var string
     */
    protected $entityClassName = 'Inviqa\OohRota\User\Engineer';
}
