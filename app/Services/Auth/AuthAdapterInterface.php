<?php

namespace App\Services\Auth;

use App\Services\Auth\Exceptions\AuthException;

interface AuthAdapterInterface
{
    /**
     * @param string $login
     * @param string $password
     * @throws AuthException
     * @return void
     */
    public function login(string $login, string $password): void;

    /**
     * @return string
     */
    public function getSystem(): string;
}
