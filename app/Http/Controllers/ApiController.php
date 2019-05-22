<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
class ApiController extends Controller
{
    //注册
    public function apireg(){
        return view('/Api/reg');
    }
    //文件上传
    public function img(Request $request,$api_img){
        if ($request->hasFile($api_img) && $request->file($api_img)->isValid()) {
            $photo = $request->file($api_img);
            $api_img = "api_img/";
            $store_result = $photo->store($api_img.date('Ymd'));
            return trim($store_result,$api_img);
        }
        exit('未获取到上传文件或上传过程出错');
    }
    //注册执行
    public function apiregadd(Request $request){
        $uid = Auth::id();
        if(empty($uid)){
            $res = [
                'error'=>50000,
                'msg'=>'请先登录'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        $data = $request->input();
        $info = [
            'api_name'=>$data['api_name'],
            'api_home'=>$data['api_home'],
            'api_shui'=>$data['api_shui'],
            'api_zh'=>$data['api_zh'],
            'api_img'=>$this->img($request,'api_img'),
            'uid'=>Auth::id(),
            'create_time'=>time()
        ];
        $res = DB::table('api')->insert($info);
        if($res){
            $res = [
                'api_name'=>$info['api_name'],
                'error'=>0,
                'msg'=>'注册成功，等待审核，查看进程'
            ];
        }else{
            $res = [
                'error'=>40001,
                'msg'=>'注册失败'
            ];
        }
        if($res['error']==0){
            echo $res['msg'];
            $api_name=urlencode($data["api_name"]);
            header("refresh:3;url=/Api/apiuser?api_name=$api_name");
        }else{
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }
    //查看个人信息
    public function apiuser(Request $request){
        $api_name = $request->input('api_name');
        $res = DB::table('api')->where(['api_name'=>$api_name])->first();
        return view('/Api/apiuser',compact('res'));
    }
}
