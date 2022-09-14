<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\InviteMail;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\GroupService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GroupController extends Controller
{
    private GroupService $group;

    /**
     * @param GroupService $group_manage
     */
    public function __construct(GroupService $group)
    {
        $this->group = $group;
    }

    /**
     * 招待メール機能
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function inviteUser(Request $request): JsonResponse
    {
        $record = Group::where('user_id', Auth::id())->first();
        $group_owner = User::findOrFail(Auth::id());
        $user_ids = $record->user()->get()->pluck('id');
        // $user_ids = $this->group->fetchGroupUserIds($record->id);
        $invite_user = User::where('email', $request->email)->first();
        $invite_url = "http://127.0.0.1:8080/api/v1/groups/joinGroup/{$record->id}";

        if (!$user_ids->contains($invite_user->id)) {
            // $record->user()->attach($invite_user->id);
            Mail::send(new InviteMail($invite_user,$record,$invite_url,$group_owner));
            return returnMessage(true, 'Group successfully joined');
        } else {
            return returnMessage(false, 'Group failed already joined', [], 409);
        }
    }

    /**
     * 招待メール経由でメンバーを追加する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function joinGroup(Request $request): JsonResponse
    {
        $joinGroup = Group::findOrfail($request->id);
        $invite_user_id = Auth::id();

        $joinGroup->user()->attach($invite_user_id);

        return returnMessage("true","success");
    }

    /**
     * グループの詳細を取得
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $group = $this->group->getGroup($id);

            return returnMessage(true,'success',$group->toArray());

    }

    /**
     * グループの更新情報を取得し、更新処理を行う
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $group = $this->group->updateGroup($request, $id);

        if($group){
            return returnMessage(true,"successly update group",[]);
        }else{
            return returnMessage(false, "failed update group", [],500);
        }
    }

    /**
     * グループに所属するユーザーを取得し、該当のユーザーを削除する
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $record = $this->group->getGroup($id);
        $user_ids = $this->group->fetchGroupUserIds($record->id);

        if ($user_ids->contains(Auth::id())) {
            $record->user()->detach(Auth::id());
            return returnMessage(true, 'success leave the group', $record->toArray());
        } else {
            return returnMessage(false, 'already leave the group', [], 409);
        }
    }
}
