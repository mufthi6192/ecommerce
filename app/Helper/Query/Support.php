<?php

if(!function_exists('countDb')){
    function countDb($table, array $param): int
    {
        $query = \Illuminate\Support\Facades\DB::table($table)
                                    ->where($param)
                                    ->count();
        return (int)$query;
    }
}

if(!function_exists('firstDb')){
    function firstDb($table, array $param): object|null
    {
        return \Illuminate\Support\Facades\DB::table($table)
                                                ->where($param)
                                                ->first();
    }
}
