<?php

namespace App\Repositories\Admin\Home;

use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Exception;
use Throwable;

class HomeRepository implements HomeInterface{

    public function allData(): array
    {
        try{
            $adminTotal = DB::table('users')->count();
            $productTotal = DB::table('product_models')->count();
            $categoryTotal =  DB::table('category_models')->count();
            $imageTotal = DB::table('product_images')->count() + $productTotal;

            $data = array(
                'product_total' => $productTotal,
                'image_total' => $imageTotal,
                'category_total' => $categoryTotal,
                'admin_total' => $adminTotal
            );

            return apiStandardSuccessFormatter($data,'Successfully get data',200);
        }catch (Throwable $err){
            $data = array(
              'product_total' => 0,
              'image_total' => 0,
              'category_total' => 0,
              'admin_total' => 0
            );
            return apiStandardFailedFormatter($data,$err->getMessage(),$err->getCode());
        }
    }
}
