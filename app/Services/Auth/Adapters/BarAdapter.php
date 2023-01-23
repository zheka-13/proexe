<?php

namespace App\Services\Auth\Adapters;

use App\Services\Auth\AuthAdapter;
use App\Services\Auth\Enums\CompanyPrefixesEnum;
use App\Services\Auth\Exceptions\AuthException;
use External\Bar\Auth\LoginService;

class BarAdapter implements AuthAdapter
{

    /**
     * @var LoginService
     */
    private $loginService;

    /**
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * @param string $login
     * @param string $password
     * @return void
     * @throws AuthException
     */
    public function login(string $login, string $password): void
    {
        if (!$this->loginService->login($login, $password)){
            throw new AuthException("Authentication failed");
        }
    }

    public function getSystem(): string
    {
        return CompanyPrefixesEnum::PREFIX_BAR;
    }
}
