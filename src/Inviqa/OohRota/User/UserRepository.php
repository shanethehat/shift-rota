<?php

namespace Inviqa\OohRota\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function fetchAll();

    /**
     * @param String $name
     * @return User
     */
    public function findByName($name);
}
