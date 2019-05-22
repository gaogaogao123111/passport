<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Redis;
class Stoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->input('token');
        if(empty($token)){
            die("token为空，获取失败");
        }
        $token_key = 'token:sadd';
        $a = Redis::sIsMember($token_key,$token);
        if($token!=$a){
            die("token无效，获取失败");
        }
        return $next($request);
    }
}
