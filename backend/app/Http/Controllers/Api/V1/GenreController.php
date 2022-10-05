<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\GenreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    private $genreService;

    private const SUCCESS_MASSAGE = 'Genre API Responce Success';

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    /**
     * ジャンル一覧を返却
     * @return JsonResponse
     */
    public function fetchGenreLists(): JsonResponse
    {
        return returnMessage(true, self::SUCCESS_MASSAGE, $this->genreService->fetchGenreLists());
    }
}
