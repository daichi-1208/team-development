<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    /**
     * リレーション
     */
    public function tag(){
        return $this->belongsToMany(Tag::class);
    }
}
