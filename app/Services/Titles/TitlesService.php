<?php

namespace App\Services\Titles;

use App\Services\Titles\Exceptions\TitlesUnavailableException;
use App\Services\Titles\StorageAdapters\BarStorage;
use App\Services\Titles\StorageAdapters\BazStorage;
use App\Services\Titles\StorageAdapters\FooStorage;
use Illuminate\Contracts\Container\BindingResolutionException;

class TitlesService
{
    public const CACHE_TIME = '5 minutes';

    private $storages = [
        BarStorage::class,
        BazStorage::class,
        FooStorage::class
    ];

    /**
     * @throws BindingResolutionException
     * @throws TitlesUnavailableException
     */
    public function getTitles(): array
    {
        $titles = [];
        foreach ($this->storages as $storage_class){
            $storage = app()->make($storage_class);
            $titles = array_merge($titles, $storage->getTitles());
        }
        return array_filter($titles);
    }

}
