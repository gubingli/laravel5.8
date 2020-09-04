<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
      return  $user;
        //$token = auth('users')->fromUser($user);
       // return $this->respondWithToken($token);

    }

    public function login()
    {
        $user = User::find(1);
        $token = auth()->login($user);

        return $token;
    }


}
