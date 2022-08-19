<?php

namespace App\Services;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenGraph;
use Illuminate\Support\Facades\Storage;

class BookmarkService
{

    private const BOOKMARK_IMAGE_PATH = 'Images/';
    private const NO_IMAGE_PATH = 'hogehoge';

    private $bookmark;

    /**
     * @param Bookmark $bookmark
     */
    public function __construct(Bookmark $bookmark)
    {
        $this->bookmark = $bookmark;
    }

    /**
     * @param integer $groupId
     * @return array
     */
    public function fetchGroupBookmarks(int $groupId): array
    {
        return Bookmark::where('group_id', '=', $groupId)->get()->toArray();
    }

    /**
     * @param integer $groupId
     * @param integer $userId
     * @return array
     */
    public function fetchGroupUserBookmarks(int $groupId, int $userId): array
    {
        return Bookmark::where('group_id', '=', $groupId)
                        ->where('user_id', '=', $userId)
                        ->get()
                        ->toArray();
    }
    
    /**
     * @param integer $bookmarkId
     * @return array
     */
    public function showBookmark(int $bookmarkId): array
    {
        return Bookmark::where('id', '=', $bookmarkId)->get()->toArray();
    }

    /**
     * @param Request $request
     * @return string
     */
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
            $messages = 'Bookmark successfully created';
        } catch(\Exception $e) {
            // laravel.logにエラーメッセージを吐く
            logger()->info($e->getMessage());
            // メッセージにはなにかしらで失敗した旨をつっこむ
            $messages = 'Bookmark Failed created';
        }
        return $messages;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateBookmark(Request $request): void
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

    /**
     * @param integer $bookmarkId
     * @return void
     */
    public function deleteBookmark(int $bookmarkId): void
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
            // 元画像の拡張子を引っこ抜く
            $extension = pathinfo($imageUrl,PATHINFO_EXTENSION);
            $downlordImage = file_get_contents($imageUrl);
            $imagePath = self::BOOKMARK_IMAGE_PATH . uniqid() . '.' .$extension;
            // ローカル保存処理
            Storage::disk('public')->put($imagePath, $downlordImage);
        } else {
            // 画像なかったらデフォルト画像みたいなのを出すようにする？
            $imagePath = self::NO_IMAGE_PATH;
        }
        return $imagePath;
    }
}