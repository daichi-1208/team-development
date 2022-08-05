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
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchGroupBookmarks(Request $request): JsonResponse
    {
        $groupId = $request->input('group_id');
        $result = $this->bookmarkService->fetchGroupBookmarks($groupId);
        
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchGroupUserBookmarks(Request $request): JsonResponse
    {
        $groupId = $request->input('group_id');
        $userId = $request->input('user_id');
        $result = $this->bookmarkService->fetchGroupUserBookmarks($groupId, $userId);

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function showBookmark(Request $request): JsonResponse
    {
        $bookmarkId = $request->input('bookmark_id');
        $result = $this->bookmarkService->showBookmark($bookmarkId);

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createBookmark(Request $request): JsonResponse
    {
        $this->bookmarkService->createBookmark($request);
        
        return response()->json([
            'status' => 'Success',
            'message' => 'Bookmark successfully created'
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
