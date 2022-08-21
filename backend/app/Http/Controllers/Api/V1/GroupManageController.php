<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\GroupManageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\NoReturn;

class GroupManageController extends Controller
{
    private GroupManageService $groupManage;

    /**
     * @param GroupManageService $group_manage
     */
    public function __construct(GroupManageService $group_manage)
    {
        $this->groupManage = $group_manage;
    }

    /**
     * 自分が作成したグループと参加しているグループを取得
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $my_groups = $this->groupManage->fetchMyGroups();
        $join_groups = $this->groupManage->fetchJoinGroups($my_groups);

        return returnMessage(true, 'Groups get successfully',
            [
                'myGroups' => $my_groups,
                'joinGroups' => $join_groups
            ]
        );
    }

    /**
     * 新しくグループを作成
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $response = $this->groupManage->createGroup($request);
        if ($response) {
            return returnMessage(true, 'Groups successfully created', [$response]);
        } else {
            return returnMessage(false, 'Group failed created', [], 500);
        }
    }

    /**
     * グループ情報を更新
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if ($this->groupManage->updateGroup($request, $id)) {
            return returnMessage(true, 'Group successfully updated', []);
        } else {
            return returnMessage(false, 'Group failed updated', [], 500);
        }
    }

    /**
     * グループを削除
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->groupManage->destroyGroup($id)) {
            return returnMessage(true, 'Group successfully destroyed', []);
        } else {
            return returnMessage(false, 'Group failed destroyed', [], 500);
        }
    }
}
