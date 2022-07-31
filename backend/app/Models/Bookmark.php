<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';
    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * グループのブックマークを全て取得して返却
     * @param integer $groupId
     * @return Collection
     */
    public function fetchGroupBookmarks(int $groupId): Collection
    {
        return $this::where('group_id', '=', $groupId)->get();
    }

    /**
     * ユーザーのブックマークを全て取得して返却
     * @param integer $userId
     * @return Collection
     */
    public function fetchUserBookmarks(int $userId): Collection
    {
        return $this::where('user_id', '=', $userId)->get();
    }

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
}
