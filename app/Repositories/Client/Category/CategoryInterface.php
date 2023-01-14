<?php

namespace App\Repositories\Client\Category;

interface CategoryInterface{
    public function allData();
    public function findProduct($keyword);
}
