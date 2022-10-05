<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CommentService
{

    private $comment;

    /**
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param integer $bookmarkId
     * @return array
     */
    public function fetchBookmarkComments(int $bookmarkId): array
    {
        return Comment::where('bookmark_id', '=', $bookmarkId)
                        ->where('is_publish', '=', true)
                        ->get()
                        ->toArray();
    }

    public function fetchUserOnlyComments()
    {
        // ブックマークに紐づいた自分が投稿したコメントだけが見えるやつ(公開・非公開があるため)
        // 一旦なしでいいかも？保留
    }

    /**
     * @param Request $request
     * @return string
     */
    public function createComment($request): string
    {
        // インサート処理
        DB::beginTransaction();
        try {
            $this->comment->create([
                'bookmark_id' => $request->bookmark_id,
                'user_id'     => Auth::id(),
                'comment'     => $request->comment,
                'is_publish'  => $request->is_publish,
            ]);
            // 正常に作成できたらcommit
            DB::commit();
            // 成功ステータスを返す
            $messages = 'Comment successfully created';
        } catch(\Exception $e) {
            // laravel.logにエラーメッセージを吐く
            logger()->error($e->getMessage());
            // メッセージにはなにかしらで失敗した旨をつっこむ
            $messages = 'Comment Failed created';
        }

        return $messages;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateComment($request): void
    {
        $updateComment = $this->comment->find($request->id);

        $updateComment->comment = $request->comment;
        $updateComment->is_publish = $request->is_publish;

        $updateComment->save();
    }

    /**
     * @param integer $commentId
     * @return void
     */
    public function deleteComment(int $commentId): void
    {
        $this->comment->where('id', $commentId)->delete();
    }
}