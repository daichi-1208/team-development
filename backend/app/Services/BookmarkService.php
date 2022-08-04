<?php

namespace App\Services;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookmarkService
{
    private $bookmark;

    public function __construct(Bookmark $bookmark)
    {
        $this->bookmark = $bookmark;
    }

    public function fetchGroupBookmarks(int $groupId): Collection
    {
        return Bookmark::where('group_id', '=', $groupId)->get();
    }

    public function fetchGroupUserBookmarks(int $groupId, int $userId): Collection
    {
        return Bookmark::where('group_id', '=', $groupId)
                        ->where('user_id', '=', $userId)
                        ->get();
    }
    
    public function showBookmarkDetail(int $bookmarkId)
    {
        return Bookmark::where('id', '=', $bookmarkId)->get();
    }

    public function createBookmark(array $data)
    {
        

    }


}