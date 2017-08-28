<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    /**
     * 管理员登录 获取access_token
     *
     * 对应路由 post api/dashboard/login
     *
     * @method token
     * @param Request $request
     * @return Request appliction/token
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $user = User::orWhere('email', $username)->orWhere('phone', $username)->orWhere('name', $username)->first();
        
        $return = [];
        if ($user && ($user->status == 0)) {
            $return = ['msg'=>'账号已被禁用','code'=>403];
        } elseif ($user && ($user->is_admin == 0)) {
            $return = ['msg'=>'不是管理员账号','code'=>403];
        } elseif (!$user) {
            $return = ['msg'=>'账号不存在','code'=>404];
        }
        if (!empty($return)) {
            return response()->json(['message'=>$return['msg']], $return['code']);
        }

        $param = config('passport');
        $param['username'] = $username;
        $param['password'] = $password;

        // 请求access_token
        $client = new Client();
        // try {
            $response = $client->request('POST', request()->root().'/oauth/token', ['form_params'=>$param]);
            return $response;
        // } catch (RequestException $e) {
            // return response()->json(['message'=>'密码错误'], 401);
        // }

        Auth::login($user, true);
        
        return $response;
    }

    public function unlock(Request $request)
    {
        if (Auth::attempt(['id' => $request->input('id'), 'password'=>$request->input('password'),'status' => 1])) {
            $param = config('passport');
            $param['grant_type'] = 'refresh_token';
            $param['refresh_token'] = $request->input('refresh_token');
            $client = new Client;
            $res = $client->request('POST', request()->root() . '/oauth/token', ['form_params' => $param]);
            return $res;      
        } else {
            return response()->json(['message'=>'密码错误'], 401);
        }
    }

    public function refresh(Request $request)
    {
        $param = config('passport');
        $param['grant_type'] = 'refresh_token';
        $param['refresh_token'] = $request->input('refresh_token');
        $client = new Client;
        $res = $client->request('POST', request()->root() . '/oauth/token', [
            'form_params' => $param
        ]);
        return $res;
    }
}
