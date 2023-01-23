<?php

namespace App\Services\Auth;

use App\Services\Auth\Adapters\BarAdapter;
use App\Services\Auth\Adapters\BazAdapter;
use App\Services\Auth\Adapters\FooAdapter;
use App\Services\Auth\Enums\CompanyPrefixesEnum;
use App\Services\Auth\Exceptions\CompanyNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;

class AuthFactory
{

    /**
     * @throws BindingResolutionException
     * @throws CompanyNotFoundException
     */
    public static function buildAuth(string $prefix): AuthAdapter
    {
        switch ($prefix){
            case CompanyPrefixesEnum::PREFIX_BAR:
                return app()->make(BarAdapter::class);
            case CompanyPrefixesEnum::PREFIX_BAZ:
                return app()->make(BazAdapter::class);
            case CompanyPrefixesEnum::PREFIX_FOO:
                return app()->make(FooAdapter::class);
            default:
                throw new CompanyNotFoundException();
        }
    }
}
