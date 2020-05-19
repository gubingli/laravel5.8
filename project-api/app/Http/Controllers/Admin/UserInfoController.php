<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserInfoController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;

        $users = User::with('userInfo')->orderBy('sort','desc')->get();
        return $this->response->array(['data' => $users])->setStatusCode(201);
    }

}
