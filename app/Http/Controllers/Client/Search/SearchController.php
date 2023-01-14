<?php

namespace App\Http\Controllers\Client\Search;

use App\Http\Controllers\Controller;
use App\Repositories\Client\Category\CategoryInterface;
use App\Repositories\Client\Product\ProductInterface;

class SearchController extends Controller
{
    private CategoryInterface $category;
    private ProductInterface $product;

    public function __construct(CategoryInterface $category, ProductInterface $product){
        $this->product = $product;
        $this->category = $category;
    }

    public function allData($keyword){
        $product = $this->product->searchData($keyword);
        if($product['status'] == false){
            return redirect()->route('404');
        }
        return responseFormatter($product);
    }

    public function index($keyword){

        $category = $this->category->allData();

        if($category['status'] == false){
            return redirect()->route('404');
        }

        return view('Client.Search.index',[
            'title' => 'Rihanna Shop - Hasil Pencarian',
            'category' => $category['data'],
            'code' => 'search',
            'keyword' => $keyword
        ]);

    }

}
