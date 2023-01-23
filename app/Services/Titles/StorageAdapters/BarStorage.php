<?php

namespace App\Services\Titles\StorageAdapters;

use App\Services\Titles\Exceptions\TitlesUnavailableException;
use App\Services\Titles\StorageAdapterInterface;
use App\Services\Titles\TitlesService;
use DateTime;
use External\Bar\Exceptions\ServiceUnavailableException;
use External\Bar\Movies\MovieService;
use Illuminate\Support\Facades\Cache;

class BarStorage implements StorageAdapterInterface
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
                    $titles = $this->movieService->getTitles();
                    return array_map(function ($val){
                        return $val["title"] ?? null;
                    }, $titles['titles']);
                }
            );
        }
        catch (ServiceUnavailableException $e){
            throw new TitlesUnavailableException();
        }
    }
}
