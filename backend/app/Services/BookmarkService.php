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
    
    public function showBookmarkDetail(int $bookmarkId): Collection
    {
        return Bookmark::where('id', '=', $bookmarkId)->get();
    }

    public function createBookmark(Request $request)
    {
        try {
            // トランザクション開始
            DB::beginTransaction();

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

            DB::commit;
        } catch(Throwable $e) {
            //登録時に例外が発生したらロールバック
            DB::rollBack();
        }
    }

    public function updateBookmark(array $data)
    {
        
    }

    public function deleteBookmark(array $data)
    {
        
    }
}