<?php
namespace App\Admin\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
class ApiController extends Controller
{
    //审核猎豹
    public function apilist(){
        $res = DB::table('api')->get();
        $info = json_encode($res);
        $info = json_decode($info,true);
        return view('/Api/apilist',compact('info'));

    }
    //审核执行
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
            $rediskey = 'appid:key:token'.$appid;
            Redis::set($rediskey,$appid.$key);
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
    //验证token
    public function token(Request $request){
        $api_id = $_GET['api_id'];
        $data= DB::table('api')->where(['api_id'=>$api_id])->first();
        if($data->status==2){
            $res = [
                'error'=>50105,
                'msg'=>'该企业未审核'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        $v = 'num';
        $b = Redis::incr($v);
        if($b>=10){
            $res = [
                'error'=>50101,
                'msg'=>'次数限制'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        echo "次数：".$b;echo "<br>";
        Redis::expire($v,5);
        if(empty($data)){
            $res = [
                'error'=>50001,
                'msg'=>'参数无效'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        $key= 'appid:key:token'.$data->appid;
        $a = Redis::get($key);
        if($data->appid==$a){
            $res = [
                'error'=>0,
                'msg'=>'token能行',
                'data'=>$data,
                'token'=>$a,
                'IP'=>$_SERVER['REMOTE_ADDR'],
                'UA'=>$_SERVER['HTTP_USER_AGENT']
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }else{
            $res = [
                'error'=>50012,
                'msg'=>'token无效',
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

    }
}

