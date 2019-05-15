<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class User
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
        if(empty($_COOKIE['token'])||empty($_COOKIE['id'])){
            header("Refresh:2;url=http://passport.1809.com/User/index");
            die("请先登录");
        }
        $key = 'token';
        $r_token = Redis::get($key);
        if($_COOKIE['token'] == $r_token){
                //记录日志
//                $content = json_encode($_GET);
//                $str = date('Y-m-d H:i:s') . $content . "\n";
//                file_put_contents("logs/token.log", $str, FILE_APPEND);
        }else{
            $res = [
                'errno'=>'40005',
                'msg'=>'无效的Token'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        return $next($request);
    }
}
