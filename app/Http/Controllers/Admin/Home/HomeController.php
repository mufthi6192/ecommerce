<?php

namespace App\Http\Controllers\Admin\Home;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Home\HomeInterface;

class HomeController extends Controller
{

    private HomeInterface $home;

    public function __construct
    (
        HomeInterface $home
    ){
        $this->home = $home;
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('Admin.Main.Pages.Home.index',[
           'title' => 'Halaman Utama',
           'code' => 'home'
        ]);
    }

    public function allHome(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->home->allData();
        return apiResponseFormatter($response);
    }
}
