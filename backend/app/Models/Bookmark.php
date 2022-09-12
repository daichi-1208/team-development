<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    // bookmark初回作成時の公開初期値
    public const PUBLIC_TRUE = true;
    public const NO_IMAGE_URL = '';

    protected $table = 'bookmarks';
    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * リレーション
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function tag(){
        return $this->belongsToMany(Tag::class, 'taggable');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
