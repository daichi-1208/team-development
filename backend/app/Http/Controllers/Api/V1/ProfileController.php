<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profileService;
    private const SUCCESS_MASSAGE = 'Profile API Responce Success';
    private const FAILED_MASSAGE = 'Profile API Responce Failed';

    /**
     * @param ProfileService $profileService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * プロフィール詳細取得
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function showProfile(Request $request): JsonResponse
    {
        $userId = $request->input('user_id');
        $data = $this->profileService->showProfile($userId);

        return getJsonResponse($data);
    }

    /**
     * ブックマーク作成処理
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function createProfile(Request $request): JsonResponse
    {
        // 処理した結果をメッセージで返す
        $messages = $this->profileService->createProfile($request);

        return getJsonMessageResponse($messages);
    }

    /**
     * プロフィール更新処理
     *
     * @param Request $request
     * @return void
     */
    public function updateProfile(Request $request)
    {
        $userId = $request->input('user_id');
        $this->profileService->updateProfile($userId);

        return getJsonMessageResponse('Profile successfully updated');
    }
}
