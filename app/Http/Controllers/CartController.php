<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Busca a transação "pendente" associada ao carrinho do usuário
        $transaction = Transaction::where('status', 'pending')
                                ->whereHas('users', function ($query) use ($user) { // Esse método é usado para filtrar registros baseados em um relacionamento
                                    $query->where('users.id', $user->id); // sem a função anonima eu nao teria acesso a variavel $user
                                })
                                ->first();

        // Se existir a transação, pega os itens; caso contrário, cria um array vazio
        $cartItems = $transaction ? $transaction->items : []; // Uso de Operador ternário

        return view('Cart', compact('cartItems', 'transaction'));
    }


    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);  // Obtém a quantidade selecionada, padrão é 1

        // Verifica se o usuário já tem um carrinho
        $transaction = Transaction::where('status', 'pending')
                                  ->whereHas('users', function ($query) use ($user) {
                                      $query->where('users.id', $user->id);
                                  })
                                  ->first();

        // Se não existir um carrinho, cria um novo
        if (!$transaction) {
            $transaction = Transaction::create([
                'date' => now(),
                'total_value' => 0,
                'status' => 'pending'
            ]);

            // Relaciona o carrinho ao comprador e ao vendedor
            $transaction->users()->attach($user->id, ['role' => 'customer']); // o método attach é especifico para relacionamentos many-to-many
            $transaction->users()->attach($product->users_id, ['role' => 'seller']);
        }

        // Verifica se o produto já está no carrinho
        $cartItem = TransactionItem::where('transactions_id', $transaction->id)
                                   ->where('products_id', $product->id)
                                   ->first();

        if ($cartItem) {
            // Se o produto já está no carrinho, incrementa a quantidade
            $cartItem->quantity += $quantity;
            $cartItem->total_value = $cartItem->quantity * $product->unit_price;
            $cartItem->save(); // Método do Eloquent que salva no banco de dados
        } else {
            // Se o produto não está no carrinho, adiciona uma unidade
            TransactionItem::create([
                'quantity' => $quantity,
                'total_value' => $product->unit_price * $quantity,
                'products_id' => $product->id,
                'transactions_id' => $transaction->id
            ]);
        }

        // Atualiza o valor total do carrinho
        $transaction->total_value = $transaction->items()->sum('total_value');
        $transaction->save();

        return redirect()->route('cart')->with('message', 'Produto adicionado ao carrinho!');
    }

    public function purchaseError()
    {
        return "oi";
    }
}
