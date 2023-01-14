<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api',['except' => ['index','login','register']]);
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('Admin.Auth.Login.index',[
            'title' => 'Login Page',
            'code' => 'login'
        ]);
    }

    public function login(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        $input = $request->all();

        try{

            $validatedRequest = Validator::make($input,[
                'username' => 'required|string|max:255',
                'password' => 'required|string|max:255'
            ]);

            if($validatedRequest->fails()){
                throw new \Exception($validatedRequest->errors(),400);
            }

            $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $token = auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password']));
            if($token)
            {
                $user = Auth::user();
                $response = array(
                    'status' => true,
                    'msg' => 'Sukses ! Username dan Password anda benar',
                    'data' => array(
                        'user' => $user,
                        'token' => $token
                    ),
                    'code' => 200
                );
            }else{
                throw new \Exception('Gagal ! username atau password salah',401);
            }

        }catch (\Throwable $err){

            if(rangeNumber($err->getCode(),100,599)){
                $errCode = $err->getCode();
            }else{
                $errCode = 500;
            }

            $response = array(
              'status' => false,
              'msg' => $err->getMessage(),
              'data' => null,
              'code' => $errCode
            );
        }

        return apiResponseFormatter($response);

    }

    public function logout(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        Auth::logout(true);

        $response = array(
            'status' => true,
            'msg' => 'Berhasil login ! Silahkan melakukan login ulang',
            'data' => null,
            'code' => 200
        );

        return apiResponseFormatter($response);
    }

}
