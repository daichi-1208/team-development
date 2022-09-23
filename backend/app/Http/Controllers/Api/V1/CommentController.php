<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{

    private $commentService;

    private const SUCCESS_MASSAGE = 'Comment API Responce Success';

    /**
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchBookmarkComments(Request $request): JsonResponse
    {
        $bookmarkId = $request->input('bookmark_id');
        $result = $this->commentService->fetchBookmarkComments($bookmarkId);

        return returnMessage(true, self::SUCCESS_MASSAGE, $result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createComment(Request $request): JsonResponse
    {
        $message = $this->commentService->createComment($request);
        return returnMessage(true, $message);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateComment(Request $request): JsonResponse
    {
        $this->commentService->updateComment($request);
        return returnMessage(true, self::SUCCESS_MASSAGE);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteComment(Request $request): JsonResponse
    {
        $commentId = $request->input('comment_id');
        $this->commentService->deleteComment($commentId);
        return returnMessage(true, self::SUCCESS_MASSAGE);
    }
}
