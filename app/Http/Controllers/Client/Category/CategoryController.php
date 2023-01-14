<?php

namespace App\Http\Controllers\Client\Category;

use App\Http\Controllers\Controller;
use App\Repositories\Client\Category\CategoryInterface;

class CategoryController extends Controller
{
    private CategoryInterface $category;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    public function index($keyword){

        $category = $this->category->allData();

        if($category['status'] == false){
            return redirect()->route('404')->with(['error_messga'=>$category['msg']]);
        }

        return view('Client.Category.index',[
            'title' => 'Rihanna Shop - Halaman Kategori',
            'category' => $category['data'],
            'code' => 'category',
            'keyword' => $keyword
        ]);
    }

    public function allData(){

        $response = $this->category->allData();

        return responseFormatter($response);

    }

    public function findCategoryProduct($keyword){

        $response = $this->category->findProduct($keyword);

        return responseFormatter($response);

    }
}
