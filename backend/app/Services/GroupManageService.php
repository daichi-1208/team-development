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

class GroupManageService
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
    public function fetchGroupData(int $groupId): Model|JsonResponse
    {
        $groupData = Group::find($groupId);

        if (is_null($groupData)) {
            return returnMessage(false, 'Record Not Found', [],404);
        }

        return $groupData;
    }

    /**
     * 自分が作成したグループを取得
     *
     * @return Collection
     */
    public function fetchMyGroups(): Collection
    {
        return Group::where('user_id', '=', Auth::id())->get();
    }

    /**
     * 自分が参加しているグループの一覧を取得
     *
     * @param Collection $myGroups
     * @return Collection
     */
    public function fetchJoinGroups(Collection $myGroups): Collection
    {
        return Auth::user()->group()->whereNotIn('groups.id', $myGroups->pluck('id'))->get();
    }

    /**
     * グループを作成
     *
     * @param $request
     * @return bool|Model
     */
    public function createGroup($request): bool|Model
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string'
        ]);

        try {
            DB::beginTransaction();

            $response = $this->group->create([
                'user_id' => Auth::id(),
                'uuid' => Uuid::uuid4(),
                'name' => $validated_data['name'],
                'description' => $validated_data['description']
            ]);

            $response->user()->sync(Auth::id());

            DB::commit();

            return $response;
        } catch (Throwable $e) {
            DB::rollBack();

            return false;
        }
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
        $groupData = self::fetchGroupData($groupId);

        if (self::selfGroup($groupData)) {
            return returnMessage(false, 'Bad Request', [],400);
        }

        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string'
        ]);

        return $groupData->update([
            'name' => $validated_data['name'],
            'description' => $validated_data['description']
        ]);
    }

    /**
     * グループ削除
     *
     * @param int $groupId
     * @return JsonResponse|bool
     */
    public function destroyGroup(int $groupId): JsonResponse|bool
    {
        $groupData = self::fetchGroupData($groupId);

        if (self::selfGroup($groupData)) {
            return returnMessage(false, 'Bad Request', [],400);
        }

        return $groupData->delete();
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
