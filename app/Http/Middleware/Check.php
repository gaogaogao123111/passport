<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class Check
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
        $v = substr(md5($_SERVER['REQUEST_URI']),0,10);
        $num = 'num:time'.$v;
        $b = Redis::incr($num);
        Redis::expire($num,60);
        if($b>=20){
            Redis::expire($num,1800);
            $res = [
                'error'=>50101,
                'msg'=>'时间过了再看'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        echo "次数：".$b;echo "<br>";
        return $next($request);
    }
}
