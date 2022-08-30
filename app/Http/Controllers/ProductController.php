<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(ProductRepositoryInterface $model)
    {
        $product = $model->all();

        return view('product', compact('product'));
    }
}
