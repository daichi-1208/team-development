<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * インフォメーション一覧
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function index(Request $request)
    {
        $take = !isset($request->take) ? 10 : $request->take;    // デフォルト10件
        $information = Information::orderBy('id', 'DESC')->take($take)->get();
        return [
            'status' => 'Success',
            'information' => $information
        ];
    }

    /**
     * 特定のインフォメーション取得
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        $information = Information::find($id);
        return [
            'status' => 'Success',
            'information' => $information
        ];
    }
}
