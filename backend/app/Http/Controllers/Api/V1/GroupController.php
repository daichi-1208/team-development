<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\InviteMail;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = Group::where('user_id', Auth::id())->first();
        $user_ids = $record->user()->get()->pluck('id');
        $invite_user = User::where('email', $request->email)->first();;

        if (!$user_ids->contains($invite_user->id)) {
            $record->user()->attach($invite_user->id);
            Mail::send(new InviteMail($invite_user->first_name,$invite_user->email,$record->name));
            return returnMessage(true, 'Group successfully joined');
        } else {
            return returnMessage(false, 'Group failed already joined', [], 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);

            return returnMessage(true,'success',$group->toArray());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $group->name = is_null($request->name) ? $group->name : $request->name;
        $group->description = is_null($request->description) ? $group->description : $request->description;
        $group->save();

        return returnMessage(true,"successly update group", $group->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Group::findOrFail($id);
        $user_ids = $record->user()->get()->pluck('id');

        if ($user_ids->contains(Auth::id())) {
            $record->user()->detach(Auth::id());
            return returnMessage(true, 'success leave the group', $record->toArray());
        } else {
            return returnMessage(false, 'already leave the group', [], 409);
        }
    }
}
