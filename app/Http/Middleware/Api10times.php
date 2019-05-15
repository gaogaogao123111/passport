<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class Api10times
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
        $key = 'api10times'.$_SERVER['REMOTE_ADDR'].':token:'.$token;
        $num = Redis::get($key);
        if($num>=10){
            echo "次数限制";die;
        }
        $a = Redis::incr($key);
        echo "次数：".$a;echo "<br>";
        Redis::expire($key,20);
        return $next($request);
    }
}
