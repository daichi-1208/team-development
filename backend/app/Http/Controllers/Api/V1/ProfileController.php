<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * プロフィール詳細取得
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function showProfile(Request $request): JsonResponse
    {
        //
    }

    /**
     * ブックマーク作成処理
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function createProfile(Request $request): JsonResponse
    {
        //
    }

    /**
     * プロフィール更新処理
     *
     * @param Request $request
     * @return void
     */
    public function updateProfile(Request $request)
    {
        //
    }
}
