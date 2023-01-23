<?php

namespace App\Services\Titles\StorageAdapters;

use App\Services\Titles\Exceptions\TitlesUnavailableException;
use App\Services\Titles\StorageAdapterInterface;
use App\Services\Titles\TitlesService;
use DateTime;
use External\Foo\Exceptions\ServiceUnavailableException;
use External\Foo\Movies\MovieService;
use Illuminate\Support\Facades\Cache;

class FooStorage implements StorageAdapterInterface
{
    /**
     * @var MovieService
     */
    private $movieService;

    /**
     * @param MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @throws TitlesUnavailableException
     */
    public function getTitles(): array
    {
        try {
            return Cache::remember(
                __CLASS__ . __METHOD__,
                new DateTime(TitlesService::CACHE_TIME),
                function () {
                    return $this->movieService->getTitles();
                }
            );
        }
        catch (ServiceUnavailableException $e){
            throw new TitlesUnavailableException();
        }
    }
}
