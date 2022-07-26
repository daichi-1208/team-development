<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * リレーション
     */
    public function bookmark(){
        return $this->belongsToMany(Bookmark::class);
    }
}
