<?php

namespace App\Repositories\Client\Product;

interface ProductInterface{

    public function allData();
    public function limitData();
    public function searchData($keyword);
    public function singleData($keyword);
    public function searchDataMobile($keyword);

}
