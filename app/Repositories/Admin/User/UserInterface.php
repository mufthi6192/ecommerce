<?php

namespace App\Repositories\Admin\User;

interface UserInterface{

    public function allData();
    public function insertData($req);
    public function updateData();
    public function deleteData($idUser);
    public function dataDetails($idUser);

}
