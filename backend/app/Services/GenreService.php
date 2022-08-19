<?php

namespace App\Services;

use App\Models\Genre;

class GenreService
{
    public function fetchGenreLists(): array
    {
        return Genre::get()->toArray();
    }
}