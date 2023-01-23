<?php

namespace App\Services\Auth\Adapters;

use App\Services\Auth\AuthAdapter;
use App\Services\Auth\Enums\CompanyPrefixesEnum;
use App\Services\Auth\Exceptions\AuthException;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Failure;

class BazAdapter implements AuthAdapter
{

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @param string $login
     * @param string $password
     * @return void
     * @throws AuthException
     */
    public function login(string $login, string $password): void
    {
        $response = $this->authenticator->auth($login, $password);
        if ($response instanceof Failure){
            throw new AuthException("Authentication failed");
        }
    }

    public function getSystem(): string
    {
        return CompanyPrefixesEnum::PREFIX_BAZ;
    }
}
