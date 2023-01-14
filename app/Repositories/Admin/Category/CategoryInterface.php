<?php

namespace App\Repositories\Admin\Category;

interface CategoryInterface{

    public function insertData($req);
    public function allData();
    public function updateData($req,$idCategory);
    public function deleteData($idCategory);
    public function detailData($idCategory);

}
