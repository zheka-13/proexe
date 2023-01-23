<?php

namespace App\Http\Controllers;

use App\Services\Titles\Exceptions\TitlesUnavailableException;
use App\Services\Titles\TitlesService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     *
     *
     * @param Request $request
     * @param TitlesService $titlesService
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function getTitles(Request $request, TitlesService $titlesService): JsonResponse
    {
        try {
            return new JsonResponse($titlesService->getTitles());
        }
        catch (TitlesUnavailableException $e){
            return new JsonResponse(["status" => "failure"]);
        }

    }
}
