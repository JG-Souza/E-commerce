<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();

        // Se a rota for de admin, retorna a view admin.dashboard
        if (request()->is('admin/*'))
            return view('admin.dashboard', compact('products'));

        return view('dashboard', compact('products'));
    }

    public function show($id)
    {
        // Busca o produto pelo seu id
        $product = Product::findOrFail($id);

        // Se a rota for de admin, retorna a view admin.dashboard
        if (request()->is('admin/*'))
            return view('admin.product', compact('product'));

        return view('product', compact('product'));
    }
}
