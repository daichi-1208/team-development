<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $record = Group::where('uuid', $request->uuid)->first();
        $user_ids = $record->user()->get()->pluck('id');

        if (!$user_ids->contains(Auth::id())) {
            $record->user()->attach(Auth::id());
            return returnMessage(true, 'Group successfully joined', $record->toArray());
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
        //
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
        //
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
