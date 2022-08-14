<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    //SHOW PAGE EDITION PRODUCT
    public function edit(Product $product) 
    {
        return view('admin.product_edit', [
            'product' => $product
        ]);
    }

    //REQUEST UPDATE PRODUCT
    public function update(Product $product, Request $request) 
    {
        $input = $request->validate([
            'name' => 'string|required',
            'price' => 'string|required',
            'stock' => 'integer|nullable',
            'cover' => 'file|nullable',
            'description' => 'string|nullable'
        ]);

        $input['slug'] = Str::slug($input['name']);

        if (!empty($input['cover']) && $input['cover']->isValid()) {
            Storage::delete($product->cover ?? '');
            $file = $input['cover'];
            $path = $file->store('public/products');
            $input['cover'] = $path;
        }
        
        $product->fill($input);
        $product->save();

        return Redirect::route('admin.products');

        dd($input);

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
            'stock' => 'integer|nullable',
            'cover' => 'file|nullable',
            'description' => 'string|nullable'
        ]);
        $input['slug'] = Str::slug($input['name']);

        if (!empty($input['cover']) && $input['cover']->isValid()) {
            $file = $input['cover'];
            $path = $file->store('public/products');
            $input['cover'] = $path;
        }

        Product::create($input);

        return Redirect::route('admin.products');
    }

    public function destroy(Product $product) {
        $product->delete();
        Storage::delete($product->cover ?? '');

        return Redirect::route('admin.products');
    }

    public function destroyImage(Product $product) {
        Storage::delete($product->cover ?? '');
        $product->cover = null;

        return Redirect::back();
    }
}
