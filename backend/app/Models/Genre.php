<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';
    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * リレーション
     */
    public function bookmarks(){
        return $this->hasMany(Bookmark::class);
    }
}
