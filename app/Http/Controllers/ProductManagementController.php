<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductManagementController extends Controller
{
    public function index()
    {
        $userId = Auth::guard('web')->id();

        $products = Product::where('users_id', '=', $userId)
        ->where('quantity', '>', 0)
        ->paginate(10);

        if (request()->is('admin/*')){
            $products = product::where('quantity', '>', '0')
            ->paginate(10);

            return view('admin.products_table', compact('products'));
        }

        return view('products_table', compact('products'));
    }

    public function store(Request $request)
    {
        $imagePath = $request->hasFile('img_path')
        ? $request->file('img_path')->store('products', 'public')
        : null;

        Product::create([
            'users_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'unit_price' => $request->unit_price,
            'quantity' => $request->quantity,
            'img_path' => $imagePath,
        ]);

        return redirect()->route('index.products')->with('success', 'Produto criado com sucesso!');
    }

    public function update(Product $product, Request $request)
    {
        $request->validate([
            'img_path' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->except('img_path');

        if ($request->hasFile('img_path') && $request->file('img_path')->isValid()) {
            $imagePath = $request->file('img_path')->store('products', 'public');
            $data['img_path'] = $imagePath;
        } else {
            // Caso o campo de imagem não seja alterado, mantenha o valor atual
            $data['img_path'] = $product->img_path;
        }

        $product->update($data);

        // se for admin, redirecionar par admin, se nao, nao
        return redirect()->route('admin.index.products')->with('success', 'Produto atualizado com sucesso!');
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.index.products');
    }
}
