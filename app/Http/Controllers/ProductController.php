<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        $userId = Auth::guard('web')->id();

        $products = Product::where('users_id', '!=', $userId)->get();
        
        if (request()->is('admin/*')) // Indica que a rota deve começar com admin/ e pode ser seguida de qualquer coisa
            return view('admin.dashboard', compact('products'));

        return view('dashboard', compact('products'));
    }

    public function show($id)
    {
        // Busca o produto pelo seu id
        $product = Product::findOrFail($id);

        if (request()->is('admin/*'))
            return view('admin.product', compact('product'));

        return view('product', compact('product'));
    }
}
