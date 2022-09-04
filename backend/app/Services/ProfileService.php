<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    private const PROFILE_IMAGE_PATH = 'Images/';
    private const NO_IMAGE_PATH = 'hogehoge';

    private $profile;

    /**
     * @param Profile $profile
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * @param integer $userId
     * @return array
     */
    public function showProfile(int $userId): array
    {
        return Profile::where('user_id', '=', $userId)->get()->toArray();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function createProfile(Request $request): string
    {
        DB::beginTransaction();
        try {
            $this->profile->create([
                'user_id'           => Auth::id(),
                'self_introduction' => $request->self_introduction,
                'public'            => Profile::PUBLIC_TRUE
            ]);
            DB::commit();
            $messages = 'Profile successfully created';
        } catch(\Exception $e) {
            logger()->info($e->getMessage());
            $messages = 'Profile Failed created';
        }
        return $messages;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateProfile(Request $request): void
    {
        $this->profile->update([
            'self_introduction' => $request->self_introduction,
            'public'            => $request->public
        ]);
    }
} 