<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profileService;
    // private const SUCCESS_MASSAGE = 'Profile API Response Success';
    // private const FAILED_MASSAGE = 'Profile API Response Failed';

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

        if (!empty($data)) {
            return returnMessage(true, 'Profile successfully showed', $data, 200);
        } else {
            return returnMessage(false, 'Profile Failed showed', [], 500);
        }
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

        if ($messages == 'Profile successfully created') {
            return returnMessage(true, $messages);
        } elseif ($messages == 'Profile Failed created') {
            return returnMessage(false, $messages, [], 500);
        }
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
        $messages = $this->profileService->updateProfile($request, $userId);

        if ($messages == 'Profile successfully updated') {
            return returnMessage(true, 'Profile successfully updated');
        } elseif ($messages == 'Profile Failed updated') {
            return returnMessage(false, 'Profile Failed updated', [], 500);
        }
    }
}
