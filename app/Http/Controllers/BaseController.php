<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function responseError($params = [], $msg = 'Error') {
        return response()->json([
            'code' => -1,
            'msg' => $msg,
            'data' => $params
        ]);
    }

    public function responseSuccess($params = [], $msg="Success") {
        return response()->json([
            'code' => 0,
            'msg' => $msg,
            'data' => $params
        ]);
    }
}
