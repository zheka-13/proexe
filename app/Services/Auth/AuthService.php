<?php

namespace App\Services\Auth;

use App\Services\Auth\DTO\AuthDTO;
use App\Services\Auth\Exceptions\AuthException;
use App\Services\Auth\Exceptions\CompanyNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class AuthService
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param string $login
     * @param string $password
     * @return AuthDTO
     * @throws AuthException
     * @throws BindingResolutionException
     * @throws CompanyNotFoundException
     */
    public function auth(string $login, string $password): AuthDTO
    {
        $prefix = substr($login, 0, 3);
        $underscore = substr($login, 3, 1);
        if ($underscore != "_"){
            throw new CompanyNotFoundException();
        }

        $auth = AuthFactory::buildAuth($prefix);
        $auth->login($login, $password);
        $authDTO = new AuthDTO();
        $authDTO->login = substr($login, 4);
        $authDTO->system = $auth->getSystem();
        return $authDTO;

    }

    /**
     * @param AuthDTO $authDTO
     * @return string
     */
    public function getJwtToken(AuthDTO $authDTO): string
    {
        $algorithm    = new Sha256();
        $key = new Key(config('jwt.key'));
        return $this->builder
            ->withHeader("login", $authDTO->login)
            ->withHeader("system", $authDTO->system)
            ->getToken($algorithm, $key)->toString();
    }
}
