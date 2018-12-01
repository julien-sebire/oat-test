<?php
namespace App\DataAccess;

use App\Model\User;

interface UserProviderInterface
{
    /**
     * Returns users as an array of User objects
     *
     * @return array|User[]
     */
    public function load(): array;
}
