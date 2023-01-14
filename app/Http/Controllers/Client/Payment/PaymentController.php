<?php

namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use App\Repositories\Client\Category\CategoryInterface;
use function view;

class PaymentController extends Controller
{

    private CategoryInterface $category;

    public function __construct(
        CategoryInterface $category
    )
    {
        $this->category = $category;
    }

    public function index(){

        $category = $this->category->allData();

        return view('Client.Payment.index',[
            'title' => 'Metode Pembayaran',
            'category' => $category['data'],
            'code' => 'payment'
        ]);

    }
}
