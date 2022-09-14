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

}
