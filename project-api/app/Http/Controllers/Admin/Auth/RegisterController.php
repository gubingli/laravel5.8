<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

//    /**
//     * Get a validator for an incoming registration request.
//     *
//     * @param  array  $data
//     * @return \Illuminate\Contracts\Validation\Validator
//     */
//    protected function validator(Request $request)
//    {
//        return Validator::make($request, [
//            'name' => ['required', 'string', 'max:255'],
//            'account' => ['required', 'string', 'email', 'max:255'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
//            'phone' => ['string'],
//            'role' => ['required'],
//        ]);
//    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {
        $request->validate([
            'account'    => 'required|string',
            'password'    => 'required|string',
            'role'    => 'required|integer',
        ]);

        //检测账号是否有人注册
        $user = User::where(['account'=>$request['account'],'role'=>$request['role']])->first();

        if ($user)   return $this->response->array(['message'=>'该账号已有人注册','status_code'=>200]);

        $user = User::create([
            'account' => $request['account'],
            'role' => $request['role'],
            'password' => Hash::make($request['password']),
        ]);

        $datas =  User::where('id', $user->id)->first();

        return $this->response->array(['message'=>'获取成功','status_code'=>200,'data' => $datas]);
    }


}
