<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * リレーション
     */
    public function bookmark(){
        return $this->belongsTo(Bookmark::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
