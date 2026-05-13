<?php

namespace App\Controllers;

use App\Models\ProductModel;

class HomeController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();

        $data = [
            'title' => 'Gaming Store',
            'products' => $productModel->orderBy('product_id', 'DESC')->findAll(),
        ];

        return view('home/index', $data);
    }
}