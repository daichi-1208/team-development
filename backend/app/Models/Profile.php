<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // profile初回作成時の公開初期値
    // public const PUBLIC_TRUE = true;

    protected $table = 'profiles';
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
}
