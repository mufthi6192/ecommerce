<?php

use Illuminate\Support\Facades\DB;

if(!function_exists('categoryName')){

    function categoryName($idCategory){
        return DB::table('category_models')
            ->where('id','=',$idCategory)
            ->select('category_name')
            ->first();
    }

}
