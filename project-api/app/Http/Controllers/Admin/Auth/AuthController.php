<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login','logout']]);

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['account', 'password','role']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->response->array(['message'=>'账号或密码有误，请重新登录','status_code'=>403]);
        }

        $user = User::where(['role'=>$credentials['role'],'account'=>$credentials['account']])->first();
        $credentials['user_id'] = $user->id;

        return $this->respondWithToken($token,$credentials);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return $this->response->array(['message' => '退出成功'])->setStatusCode(200);
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$datas)
    {
        $data = [
            'access_token' => $token,
            'role' => $datas['role'],
            'user_id' => $datas['user_id'],
            'account' => $datas['account'],
        ];

        return $this->response->array(['message'=>'登录成功','status_code'=>200,'data'=>$data]);

    }
}
