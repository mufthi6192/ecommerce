<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Category\CategoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private CategoryInterface $category;

    public function __construct
    (
        CategoryInterface $category
    ){
        $this->category = $category;
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('Admin.Main.Pages.Category.index',[
            'title' => 'Halaman Kategori Produk',
            'code' => 'category'
        ]);
    }

    public function addCategory(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->category->insertData($request);
        return apiResponseFormatter($response);
    }

    public function allCategory(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->category->allData();
        return apiResponseFormatter($response);
    }

    public function updateCategory(Request $request, $idCategory): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->category->updateData($request,$idCategory);
        return apiResponseFormatter($response);
    }

    public function deleteCategory($idCategory): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->category->deleteData($idCategory);
        return apiResponseFormatter($response);
    }

    public function detailCategory($idCategory): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->category->detailData($idCategory);
        return apiResponseFormatter($response);
    }

}
