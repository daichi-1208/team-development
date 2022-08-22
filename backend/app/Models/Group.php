<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'uuid', 'name', 'description'];

    /**
     * リレーション
     */
    public function user(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
