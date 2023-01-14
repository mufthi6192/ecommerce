<?php

namespace App\Http\Controllers\Client\Home;

use App\Http\Controllers\Controller;
use App\Repositories\Client\Category\CategoryInterface;
use App\Repositories\Client\Product\ProductInterface;

class HomeController extends Controller
{

    private CategoryInterface $category;
    private ProductInterface $product;

    public function __construct(
        CategoryInterface $category,
        ProductInterface $product,
    )
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        $category = $this->category->allData();
        $product = $this->product->limitData();


        if($category['status'] == false){
            return redirect()->route('404');
        }

        if($product['status']==false){
            return redirect()->route('404');
        }


        return view('Client.Home.home',[
            'title' => 'Halaman Utama',
            'category' => $category['data'],
            'product' => $product['data'],
            'code' => 'home'
        ]);
    }
}
