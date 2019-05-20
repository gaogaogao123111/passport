<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class ApiController extends Controller
{
    //注册
    public function apireg(){
        return view('/Api/reg');
    }
    //注册执行
    public function apiregadd(Request $request){
        $data = $request->input();
        $info = [
            'api_name'=>$data['api_name'],
            'api_home'=>$data['api_home'],
            'api_shui'=>$data['api_shui'],
            'api_zh'=>$data['api_zh'],
        ];
        $res = DB::table('api')->insert($info);

        if($res){
            $res = [
                'error'=>0,
                'msg'=>'等待审核'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
//            return view('/Api/apilist',compact('info'));

        }else{
            $res = [
                'error'=>40001,
                'msg'=>'注册失败'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
    }
}
