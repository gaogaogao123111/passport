<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Api/user', 'ApiController@user');
Route::post('/Api/add', 'ApiController@add');
Route::get('/Api/apitest', 'ApiController@apitest');
Route::get('/Api/apitestadd', 'ApiController@apitestadd');
Route::get('/Api/apitestadd2', 'ApiController@apitestadd2');
Route::get('/Api/apitestadd3', 'ApiController@apitestadd3');



Route::get('/Api/times', 'ApiController@times')->middleware('api10times');



Route::post('/User/appregadd', 'UserController@appregadd');
Route::post('/User/apploginadd', 'UserController@apploginadd');
Route::post('/User/user', 'UserController@user');
Route::get('/User/my', 'UserController@my')->middleware(['user','api10times']);


Route::resource('/Goods',GoodsController::class);

Route::get('/User/index', 'UserController@index');
Route::post('/User/login', 'UserController@login');

//支付
Route::get('/test','PayController@test');//测试
Route::get('/pay/alipay/pay/{order_id}','PayController@pay');
Route::post('/pay/notify', 'PayController@notify');       //支付宝异步通知
Route::get('/pay/alipay/aliReturn', 'PayController@aliReturn');       //支付宝同步通知



//api
Route::get('/Api/apireg','ApiController@apireg');
Route::post('/Api/apiregadd','ApiController@apiregadd');
Route::get('/Api/apilist','ApiController@apilist');

Route::get('/Api/apiuser','ApiController@apiuser');













Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
