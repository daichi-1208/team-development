<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\BookmarkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    private $bookmarkService;

    /**
     * @param BookmarkService $bookmarkService
     */
    public function __construct(BookmarkService $bookmarkService)
    {
        $this->bookmarkService = $bookmarkService;
    }
    
    /**
     * グループに属するブックマーク一覧を取得
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchGroupBookmarks(Request $request): JsonResponse
    {
        $groupId = $request->input('group_id');
        $result = $this->bookmarkService->fetchGroupBookmarks($groupId);
        
        return getJsonResponse($result);
    }

    /**
     * グループに所属するユーザーが投稿したブックマーク一覧を取得
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchGroupUserBookmarks(Request $request): JsonResponse
    {
        $groupId = $request->input('group_id');
        $userId = $request->input('user_id');
        $data = $this->bookmarkService->fetchGroupUserBookmarks($groupId, $userId);

        return getJsonResponse($data);
    }

    /**
     * ブックマーク詳細取得
     * @param Request $request
     * @return JsonResponse
     */
    public function showBookmark(Request $request): JsonResponse
    {
        $bookmarkId = $request->input('bookmark_id');
        $data = $this->bookmarkService->showBookmark($bookmarkId);

        return getJsonResponse($data);
    }

    /**
     * ブックマーク作成処理
     * @param Request $request
     * @return JsonResponse
     */
    public function createBookmark(Request $request): JsonResponse
    {
        // 処理した結果をメッセージで返す
        $messages = $this->bookmarkService->createBookmark($request);
        
        return getJsonMessageResponse($messages);
    }

    /**
     * ブックマーク更新処理
     * @param Request $request
     * @return JsonResponse
     */
    public function updateBookmark(Request $request): JsonResponse
    {
        $bookmarkId = $request->input('bookmark_id');
        $this->bookmarkService->updateBookmark($bookmarkId);

        return getJsonMessageResponse('Bookmark successfully updated');
    }

    /**
     * ブックマーク削除処理
     * @param Request $request
     * @return JsonResponse
     */
    public function daleteBookmark(Request $request): JsonResponse
    {
        $bookmarkId = $request->input('bookmark_id');
        $this->bookmarkService->deleteBookmark($bookmarkId);

        return getJsonMessageResponse('Bookmark successfully daleted');
    }
}
