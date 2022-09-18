<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileService
{
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
        try {
            return Profile::where('user_id', '=', $userId)->get()->toArray();
        } catch(\Exception $e) {
            logger()->info($e->getMessage());
        }
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
                'self_introduction' => $request->self_introduction
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
     * @return string
     */
    public function updateProfile(Request $request,): string
    {
        try {
            $this->profile  
                ->where('user_id', '=', Auth::id())
                ->update([
                    'self_introduction' => $request->self_introduction
                ]);
            $messages = 'Profile successfully updated';
        } catch(\Exception $e) {
            logger()->info($e->getMessage());
            $messages = 'Profile Failed updated';
        }
        
        return $messages;
    }
} 