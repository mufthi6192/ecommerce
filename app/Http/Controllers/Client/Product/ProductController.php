<?php

namespace App\Http\Controllers\Client\Product;

use App\Http\Controllers\Controller;
use App\Repositories\Client\Category\CategoryInterface;
use App\Repositories\Client\Product\ProductInterface;

class ProductController extends Controller
{
    private ProductInterface $product;
    private CategoryInterface $category;

    public function __construct(ProductInterface $product, CategoryInterface $category){
        $this->product = $product;
        $this->category = $category;
    }

    public function allData(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        $response = $this->product->allData();

        return responseFormatter($response);

    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        $category = $this->category->allData();

        if($category['status'] == false){
            return redirect()->route('404');
        }

        return view('Client.Product.index',[
            'title' => 'Rihanna Shop - Semua Produk',
            'category' => $category['data'],
            'code' => 'product'
        ]);

    }

    public function singleProduct($keyword): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        $category = $this->category->allData();
        $product = $this->product->singleData($keyword);

        if($category['status'] == false){
            return redirect()->route('404')->with('error_message',$category['msg']);
        }

        if($product['status'] == false){
            return redirect()->route('404')->with('error_message',$product['msg']);
        }

        return view('Client.Product.single',[
            'title' => 'Rihanna Shop - Detail Produk',
            'category' => $category['data'],
            'code' => 'product-single',
            'product' => $product['data']
        ]);
    }

    public function dataMobile($keyword): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        $response = $this->product->searchDataMobile($keyword);

        return responseFormatter($response);

    }

}
