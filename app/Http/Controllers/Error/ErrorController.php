<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    public function errorNotFound(){

        return view('Client.Error.index',[
           'title' => 'Error Page'
        ]);

    }
}
