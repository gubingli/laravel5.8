<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Repositories\User\UserRepositories;
use App\Models\AuthCode;
use App\Models\NewUser;
use App\Models\User;
use App\Unit\Sms\Chanzor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

header('Access-Control-Expose-Headers:Authorization');
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verifyToken', ['except' => ['login','loginSms']]);

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $password = request('password','');
        $phone = request('phone',0);
        $credentials = ['phone'=>$phone, 'password'=>$password];

        list($bool, $user) = UserRepositories::checkPhone(request('phone', 0));

        if (!$bool) return response_json(1003, config('code.1003'));

        if ($user->status == User::STATUS_NO) return response_json(1004, config('code.1004'));

        if (! $token = auth()->attempt($credentials)) {
            return response_json(1009, config('code.1009'));
        }

        $res = $this->respondWithToken($token);
        return  $res;
    }

    /**
     * Get the authenticated Permission.
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
        auth()->logout();
        return response_json(200, 'success');
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
    protected function respondWithToken($token)
    {
        return response_json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
