<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use App\Model\User;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
	//app注册
    public function appregadd(Request $request){
        $data = file_get_contents("php://input");
        $method = 'aes-256-cbc';
        $key = 'aaaa';
        $option = OPENSSL_RAW_DATA;
        $iv = '1809180918091809';
        $data = base64_decode($data);
        $decrypted = openssl_decrypt($data, $method, $key, $option, $iv);
        $data = json_decode($decrypted,JSON_UNESCAPED_UNICODE);
        $res = User::where(['email'=>$data['email']])->first();
    	if($res){
            $res = [
                'errno'=>'50002',
                'msg'=>'email已存在'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        $password = password_hash($data['password'],PASSWORD_BCRYPT);
        $info = [
            'name'=>$data['name'],
            'email'=>$data['email'],
            'pass'=>$password,
            'create_time'=>time()
        ];
        $res = DB::table('user_api')->insert($info);
        if($res){
            $res = [
                'errno'=>'0',
                'msg'=>'OK'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }else{
            $res = [
                'errno'=>'40002',
                'msg'=>'注册失败'
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
    }
    //app登录
    public function apploginadd(Request $request){
    	$data = file_get_contents("php://input");
        $method = 'aes-256-cbc';
        $key = 'aaaa';
        $option = OPENSSL_RAW_DATA;
        $iv = '1809180918091809';
        $data = base64_decode($data);
        $decrypted = openssl_decrypt($data, $method, $key, $option, $iv);
        $data = json_decode($decrypted,JSON_UNESCAPED_UNICODE);
        $response = User::where(['email'=>$data['email']])->first();
        if($response){
            if(password_verify($data['password'],$response->pass)){
                $token = substr(md5($response->id.Str::random(5)),2,5);
                $res = [
                    'errno'=>'0',
                    'msg'=>'登录成功',
                    'data'=>[
                        'token'=>$token,
                        'id'=>$response->id
                    ]
                ];
                $key = "login:ceshiapp:token:id".$response->id;
                Redis::set($key,$token);
                Redis::expire($key,604800);
            }else{
                $res = [
                    'errno'=>'50010',
                    'msg'=>'密码不正确'
                ];
            }
        }else{
            $res = [
                'errno'=>'50002',
                'msg'=>'用户不存在'
            ];
        }
        die(json_encode($res,JSON_UNESCAPED_UNICODE));
    }

    //app个人中心
    public function user(Request $request){
    	$data = file_get_contents("php://input");
        $method = 'aes-256-cbc';
        $key = 'aaaa';
        $option = OPENSSL_RAW_DATA;
        $iv = '1809180918091809';
        $data = base64_decode($data);
        $decrypted = openssl_decrypt($data, $method, $key, $option, $iv);
        $data = json_decode($decrypted,JSON_UNESCAPED_UNICODE);
    	$a = User::where(['id'=>$data])->first();
        if($a){
            $res = [
                'errno'=>'0',
                'msg'=>'OK',
                'data'=>$a
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }else{
            $res = [
                'errno'=>'50006',
                'msg'=>'数据异常',
            ];
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
    }
}
