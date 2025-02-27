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

        $products = Product::where('users_id', '!=', $userId)
        ->where('quantity', '>', 0)
        ->paginate(12);

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

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $category = $request->input('categoria');

        $products = Product::query()
        ->where('quantity', '>', 0);

        if($searchTerm)
            $products = $products->where('name', 'like',  '%' . $searchTerm . '%');

        if($category)
            $products = $products->where('category', $category);

        $products = $products->paginate(12)->appends($request->query()); // Mantém os parâmetros na paginação

        return view('dashboard', compact('products'));
    }
}
