<?php

namespace App\Services;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use OpenGraph;
use Illuminate\Support\Facades\Storage;

class BookmarkService
{

    private const SAVE_IMAGE_PATH = 'Images/';

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


    public function createBookmark(Request $request): string
    {
        // OGPの処理をするためにURLだけ引っこ抜く
        $referenceUrl = $request->input('url');

        // OGPに関する処理を別メソッドで実行してローカルに保存したPATHを返却
        $imagePath = $this->processOGPImage($referenceUrl);

        // インサート処理
        DB::beginTransaction();
        try {
            $this->bookmark->create([
                'user_id'           => $request->user_id,
                'group_id'          => $request->group_id,
                'genre_id'          => $request->genre_id,
                'url'               => $request->url,
                'description'       => $request->description,
                'meta_image_path'   => $imagePath,
                'meta_description'  => $request->meta_description,
                'public'            => Bookmark::PUBLIC_TRUE
            ]);
            // 正常に作成できたらcommit
            DB::commit();
            // 成功ステータスを返す
            $message = 'Bookmark successfully created';
        } catch(\Exception $e) {
            $message = $e->getMessage();
        }

        return $message;
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

    /**
     * @param string $referenceUrl
     * @return string
     */
    private function processOGPImage(string $referenceUrl): string
    {
        // OGP取得
        $data = OpenGraph::fetch($referenceUrl);

        if($data['image']){
            $imageUrl = $data['image'];
            $extension = pathinfo($imageUrl,PATHINFO_EXTENSION);
        }

        $downlordImage = file_get_contents($imageUrl);
        $imagePath = self::SAVE_IMAGE_PATH . uniqid() . '.' .$extension;

        // ローカル保存処理
        Storage::disk('public')->put($imagePath, $downlordImage);

        // ローカルに保存したimageパスを返却
        return $imagePath;
    }
}