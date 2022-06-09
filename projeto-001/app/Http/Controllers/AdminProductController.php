<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    //SHOW PAGE EDITION PRODUCT
    public function edit() 
    {
        return view('admin.product_edit');
    }

    //REQUEST UPDATE PRODUCT
    public function update() 
    {

    }

    //SHOW PAGE CREATE PRODUCT
    public function create()
    {
        return view('admin.product_create');
    }

    //REQUEST CREATE NEW PRODUCT
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'string|required',
            'price' => 'string|required',
            'stock' => 'string|nullable',
            'cover' => 'file|nullable',
            'description' => 'string|nullable'
        ]);
        $input['slug'] = Str::slug($input['name']);
        Product::create($input);

        return Redirect::route('admin.products');
    }
}
