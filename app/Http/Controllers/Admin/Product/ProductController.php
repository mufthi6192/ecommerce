<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Product\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductInterface $product;

    public function __construct
    (
       ProductInterface $product
    ){
        $this->product = $product;
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('Admin.Main.Pages.Product.index',[
            'title' => 'Halaman Produk',
            'code' => 'product'
        ]);
    }

    public function addProduct(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->product->insertData($request);
        return apiResponseFormatter($response);
    }

    public function addImageProduct(Request $request, $idProduct): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->product->insertImageData($request,$idProduct);
        return apiResponseFormatter($response);
    }

    public function allProduct(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->product->allData();
        return apiResponseFormatter($response);
    }

    public function updateProduct(Request $request,$idProduct): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->product->updateData($request,$idProduct);
        return apiResponseFormatter($response);
    }

    public function detailProduct($idProduct): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->product->detailData($idProduct);
        return apiResponseFormatter($response);
    }

    public function allImageProduct($idImage): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->product->detailImageData($idImage);
        return apiResponseFormatter($response);
    }

    public function deleteProduct(Request $request,$idProduct): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->product->deleteData($idProduct);
        return apiResponseFormatter($response);
    }

}
