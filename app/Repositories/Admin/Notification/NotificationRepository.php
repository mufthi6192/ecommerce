<?php

namespace App\Repositories\Admin\Notification;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class NotificationRepository implements NotificationInterface{

    public function allData(): array
    {
        try{
            $query = DB::table('notification_models')
                            ->select('notification_message','notification_image','created_at')
                            ->where('user_id','=',Auth::user()->id)
                            ->limit(4)->get();
            $queryCount = DB::table('notification_models')->where('user_id','=',Auth::user()->id)->count();
            if(!$query OR $query->isEmpty() OR !$queryCount){
                throw new Exception("Gagal mendapatkan informasi notifikasi",404);
            }else{
                foreach ($query as $index => $val){
                    $data [] = array(
                        'notification_message' => $val->notification_message,
                        'notification_image' => $val->notification_image,
                        'created_at' => Carbon::parse($val->created_at)->diffForHumans(),
                    );
                }
                $allData = array(
                  'total_notification' => $queryCount,
                  'data' => $data
                );
                return apiStandardSuccessFormatter($allData,'Successfully get data',200);
            }
        }catch (Throwable $err){
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }
}
