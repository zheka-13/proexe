<?php

namespace App\Services\Auth\Adapters;

use App\Services\Auth\AuthAdapterInterface;
use App\Services\Auth\Enums\CompanyPrefixesEnum;
use App\Services\Auth\Exceptions\AuthException;
use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;

class FooAdapter implements AuthAdapterInterface
{
    /**
     * @var AuthWS
     */
    private $authWS;

    /**
     * @param AuthWS $authWS
     */
    public function __construct(AuthWS $authWS)
    {
        $this->authWS = $authWS;
    }

    public function login(string $login, string $password): void
    {
        try {
            $this->authWS->authenticate($login, $password);
        }
        catch (AuthenticationFailedException $e){
            throw new AuthException($e->getMessage());
        }
    }

    public function getSystem(): string
    {
        return CompanyPrefixesEnum::PREFIX_FOO;
    }
}
