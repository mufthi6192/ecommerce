<?php

namespace App\Repositories\Admin\Product;

interface ProductInterface{

    public function allData();
    public function insertData($req);
    public function updateData($req,$idProduct);
    public function deleteData($idProduct);
    public function detailData($idProduct);
    public function insertImageData($req,$idProduct);
    public function detailImageData($idImage);

}
