<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();

        return view('dashboard', compact('products'));
    }

    public function show($id)
    {
        // Busca o produto pelo seu id
        $product = Product::findOrFail($id);

        return view('product', compact('product'));
    }
}
