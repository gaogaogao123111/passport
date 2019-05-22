<?php
namespace App\Admin\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
class ApiController extends Controller
{
    public function apilist(){
        $res = DB::table('api')->get();
        $info = json_encode($res);
        $info = json_decode($info,true);
        return view('/Api/apilist',compact('info'));

    }
    public function gocheck(Request $request){
        $data = $request->input();
        $v = DB::table('api')->where(['api_id'=>$data['id']])->update(['status'=>1]);
        if($v){
            $appid = rand(0,9).'176'.rand(0,9);
            $key = Str::random(3).'1';
            $vv = [
                'appid'=>$appid,
                'key'=>$key
            ];
            DB::table('api')->where(['api_id'=>$data])->update($vv);
            $res = [
                'error'=>0,
                'msg'=>'审核成功'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }else{
            $res = [
                'error'=>10051,
                'msg'=>'审核失败'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
    }
    //获取token
    public function token(Request $request){
        $api_id = $_GET['api_id'];
        $key= $_GET['key'];
        $data= DB::table('api')->where(['api_id'=>$api_id])->first();
        if(empty($data)){
            $res = [
                'error'=>50001,
                'msg'=>'参数无效'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        if($data->key!=$key){
            $res = [
                'error'=>50105,
                'msg'=>'key不匹配'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        $token = Str::random(5).rand(5,10);
        $rediskey = 'appid:key:token'.$data->appid;
        $token_key = 'token:sadd';
        Redis::set($rediskey,$token);
        $a = Redis::Sadd($token_key,$token);
        if($a){
            $res = [
                'error'=>0,
                'msg'=>'获取token成功',
                'token'=>$token,
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }else{
            $res = [
                'error'=>50012,
                'msg'=>'获取token失败',
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

    }
    //获取IP
    public function ip(Request $request){
        $appid = $request->input('appid');
        $data= DB::table('api')->where(['appid'=>$appid])->first();
        if($data){
            $res = [
                'error'=>0,
                'msg'=>'ip',
                'data'=>$_SERVER['REMOTE_ADDR']
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }else{
            $res = [
                'error'=>40010,
                'msg'=>'无效的ID',
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

    }
    //获取UA
    public function ua(Request $request){
        $appid = $request->input('appid');
        $data= DB::table('api')->where(['appid'=>$appid])->first();
        if($data){
            $res = [
                'error'=>0,
                'msg'=>'UA',
                'data'=>$_SERVER['HTTP_USER_AGENT']
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }else{
            $res = [
                'error'=>40010,
                'msg'=>'无效的ID',
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
    }
    //获取注册信息
    public function reguser(Request $request){
        $appid = $request->input('appid');
        $data= DB::table('api')->where(['appid'=>$appid])->first();
        if($data){
            $res = [
                'error'=>0,
                'msg'=>'注册信息',
                'data'=>$data
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }else{
            $res = [
                'error'=>40010,
                'msg'=>'无效的ID',
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
    }
}

