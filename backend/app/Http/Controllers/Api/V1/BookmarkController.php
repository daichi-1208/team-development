<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\BookmarkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    private $bookmarkService;
    private const SUCCESS_MASSAGE = 'Bookmark API Responce Success';
    private const FAILED_MASSAGE = 'Bookmark API Responce Failed';

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
        
        return returnMessage(true, self::SUCCESS_MASSAGE, $result);
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
        $result = $this->bookmarkService->fetchGroupUserBookmarks($groupId, $userId);

        return returnMessage(true, self::SUCCESS_MASSAGE, $result);
    }

    /**
     * ブックマーク詳細取得
     * @param Request $request
     * @return JsonResponse
     */
    public function showBookmark(Request $request): JsonResponse
    {
        $bookmarkId = $request->input('bookmark_id');
        $result = $this->bookmarkService->showBookmark($bookmarkId);

        return returnMessage(true, self::SUCCESS_MASSAGE, $result);
    }

    /**
     * ブックマーク作成処理
     * @param Request $request
     * @return JsonResponse
     */
    public function createBookmark(Request $request): JsonResponse
    {
        $this->bookmarkService->createBookmark($request);
        return returnMessage(true, self::SUCCESS_MASSAGE);
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

        return returnMessage(true, self::SUCCESS_MASSAGE);
    }

    /**
     * ブックマーク削除処理
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteBookmark(Request $request): JsonResponse
    {
        $bookmarkId = $request->input('bookmark_id');
        $this->bookmarkService->deleteBookmark($bookmarkId);

        return returnMessage(true, self::SUCCESS_MASSAGE);
    }
}
