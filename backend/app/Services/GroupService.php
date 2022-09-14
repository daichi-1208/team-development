<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;
use Ramsey\Uuid\Uuid;
use Throwable;

class GroupService
{
    private Group $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * グループ情報取得
     *
     * @param int $groupId
     * @return Model|JsonResponse
     */
    public function getGroup(int $groupId): Model|JsonResponse
    {
        $groupData = Group::findOrFail($groupId);

        if (is_null($groupData)) {
            return returnMessage(false, 'Record Not Found', [],404);
        }

        return $groupData;
    }

    /**
     * グループに所属するユーザーのidを取得
     *
     * @return Collection
     */
    public function fetchGroupUserIds($id): Collection
    {
        return self::getGroup($id)->user()->get()->pluck('id');
    }

        /**
     * グループ情報のアップデート
     *
     * @param $request
     * @param int $groupId
     * @return JsonResponse|bool
     */
    public function updateGroup($request, int $groupId): JsonResponse|bool
    {
        $groupData = self::getGroup($groupId);

        if (self::selfGroup($groupData)) {
            return returnMessage(false, 'Bad Request', [],400);
        }

        $groupData->name = is_null($request->name) ? $groupData->name : $request->name;
        $groupData->description = is_null($request->description) ? $groupData->description : $request->description;
        return $groupData->save();
    }

        /**
     * グループが自分自身のものか確認
     *
     * @param $groupData
     * @return bool
     */
    public function selfGroup($groupData): bool
    {
        return $groupData->user_id != Auth::id();
    }

}
