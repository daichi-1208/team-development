<?php

namespace App\Services;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

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
    
    public function showBookmark(int $bookmarkId): Collection
    {
        return Bookmark::where('id', '=', $bookmarkId)->get();
    }

    public function createBookmark(Request $request)
    {
        $this->bookmark->create([
            'user_id'           => $request->user_id,
            'group_id'          => $request->group_id,
            'genre_id'          => $request->genre_id,
            'url'               => $request->url,
            'description'       => $request->description,
            'meta_image_path'   => $request->meta_image_path,
            'meta_description'  => $request->meta_description,
            'public'            => Bookmark::PUBLIC_TRUE
        ]);
    }

    public function updateBookmark(Request $request)
    {
        $this->bookmark->update([
            'genre_id'          => $request->genre_id,
            'url'               => $request->url,
            'description'       => $request->description,
            'meta_image_path'   => $request->meta_image_path,
            'meta_description'  => $request->meta_description,
            'public'            => $request->public
        ]);
    }

    public function deleteBookmark(int $bookmarkId)
    {
        $this->bookmark->where('id', $bookmarkId)->delete();
    }
}