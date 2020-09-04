<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class VerifyJWTToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // 检查此次请求中是否带有 token，如果没有则抛出异常。
            if(!$request->hasHeader('token')) throw new UnauthorizedHttpException('jwt-auth', 'Unauthorized');;

            try {
                // 检测用户的登录状态，如果正常则通过
                auth()->setToken($request->header('token'));

                if ( auth()->authenticate())
                    return $next($request);

                throw new UnauthorizedHttpException('jwt-auth', '未登录');
            } catch (\Exception $exception) {
                // 刷新用户的 token
                $newToken = auth()->refresh();

                auth()->setToken($newToken);
            }
            // 在响应头中返回新的 token
            return $this->setAuthenticationHeader($next($request), $newToken);
        } catch (UnauthorizedHttpException $exception) {
            return response_json(1001, config('code.1001'));
        } catch (TokenInvalidException | JWTException  $exception) {
            // 如果捕获到此异常，即代表 refresh 也过期了，用户无法刷新令牌，需要重新登录。
            return response_json(1002, config('code.1002'));
        }
    }

}
