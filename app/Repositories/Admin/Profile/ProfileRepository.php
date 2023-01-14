<?php

namespace App\Repositories\Admin\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfileRepository implements ProfileInterface{

    public function userProfile(): array
    {
        try{
            $name = Auth::user()->name;
            $email = Auth::user()->email;
            $username = Auth::user()->username;
            $user_id = Auth::user()->id;

            $userDetails = DB::table('user_details')
                                ->where('user_id','=',$user_id)
                                ->first();

            if(!$name OR !$username OR !$email OR !$userDetails OR empty($userDetails) OR is_null($userDetails)){
                throw new \Exception("Terjadi kesalahan, Silahkan coba lagi",500);
            }else{
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'username' => $username,
                    'image' => $userDetails->image,
                    'level' => Str::title($userDetails->level)
                );
                $response = apiStandardSuccessFormatter($data,'Successfully get data',200);
            }
        }catch (\Throwable $err){
            $response = apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }

        return $response;
    }

}
