<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\GenreService;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    private $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    public function fetchGenreLists(Request $request): JsonResponse
    {
        $result = $this->genreService->fetchGenreLists();
        return response()->json($result);
    }
}
