<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
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
        // 一旦なしでいいかも？
    }

    public function createComment(Request $request): string
    {
        // インサート処理
        DB::beginTransaction();
        try {
            $this->comment->create([
                'bookmark_id' => $request->bookmark_id,
                'user_id'     => $request->user_id,
                'comment'     => $request->comment,
                'is_publish'  => $request->is_publish,
            ]);
            // 正常に作成できたらcommit
            DB::commit();
            // 成功ステータスを返す
            $messages = 'Comment successfully created';
        } catch(\Exception $e) {
            // laravel.logにエラーメッセージを吐く
            logger()->info($e->getMessage());
            // メッセージにはなにかしらで失敗した旨をつっこむ
            $messages = 'Comment Failed created';
        }
        
        return $messages;
    }

    public function updateComment()
    {
        // 名前の通り
    }

    public function deleteComment()
    {
        // 名前の通り
    }
}