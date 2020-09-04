<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/5/28
 * Time: 13:31
 */

namespace App\Facades\Repositories\User;

use App\Facades\Repositories\Repository;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepositories extends Repository
{

    /**
     * @var NewUser
     */
    protected $model;

    public function model()
    {
        return User::class;
    }

    public static function checkPhone($phone)
    {
        $res = [false, 0];

        if ($phone) $user = User::where('phone', $phone)->first();

        if (isset($user) && $user instanceof $user) return $res = [true, $user];

        return $res;
    }

    public static function login()
    {
        $info = [
            'login_ip'=>request()->getClientIp(),
            'login_at'=>Carbon::now()->toDateTimeString(),
        ];
        return auth()->user()->update($info);
    }

}

