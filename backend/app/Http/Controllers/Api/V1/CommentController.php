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

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function fetchBookmarkComments(Request $request)
    {
        $bookmarkId = $request->input('bookmark_id');
        $result = $this->commentService->fetchBookmarkComments($bookmarkId);

        return returnMessage(true, self::SUCCESS_MASSAGE, $result);
    }

    public function createComment(Request $request)
    {
        $message = $this->commentService->createComment($request);

        return returnMessage(true, $message);
    }
}
