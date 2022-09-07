<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profileService;
    private const SUCCESS_MASSAGE = 'Profile API Response Success';
    private const FAILED_MASSAGE = 'Profile API Response Failed';

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

        return returnMessage(true, 'Success', $data);
    }

    /**
     * ブックマーク作成処理
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function createProfile(Request $request): JsonResponse
    {
        $messages = $this->profileService->createProfile($request);

        return returnMessage(true, $messages);
    }

    /**
     * プロフィール更新処理
     *
     * @param Request $request
     * @return void
     */
    public function updateProfile(Request $request)
    {
        $this->profileService->updateProfile($request);

        return returnMessage(true, 'Profile successfully updated');
    }
}
