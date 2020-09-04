<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function detail()
    {
        $user = auth()->user();

        $new_user = User::find($user->id);

        $role = RoleUser::where('user_id',$user->id)->get()->toArray();
        if(!empty($role)) {
            $role_ids = array_column($role,'role_id');
            $new_user['rids']= $role_ids;
        }

        return $new_user;
    }


}
