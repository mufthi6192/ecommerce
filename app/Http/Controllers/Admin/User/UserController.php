<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\User\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserInterface $user;

    public function __construct
    (
        UserInterface $user
    ){
        $this->user = $user;
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('Admin.Main.Pages.User.index',[
            'title' => 'Halaman User',
            'code' => 'user'
        ]);
    }

    public function insertUser(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->user->insertData($request);
        return responseFormatter($response);
    }

    public function allUser(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->user->allData();
        return responseFormatter($response);
    }

    public function deleteUser($idUser): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->user->deleteData($idUser);
        return responseFormatter($response);
    }

    public function detailUser($idUser): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->user->dataDetails($idUser);
        return responseFormatter($response);
    }
}
