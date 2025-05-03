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
        $transaction = $this->getUserPendingTransaction($user);

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
        $transaction = $this->getUserPendingTransaction($user);

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
        $this->updateTransactionTotal($transaction);

        return redirect()->route('cart')->with([
            'message' => 'Produto adicionado ao carrinho com sucesso!',
            'message_type' => 'success'
        ]);
    }

    public function updateQuantity(Request $request, $productId, $action)
    {
        $user = Auth::user();

        $transaction = $this->getUserPendingTransaction($user);

        if (!$transaction) {
            return redirect()->route('cart')->with('error', 'Carrinho não encontrado.');
        }

        $cartItem = TransactionItem::where('transactions_id', $transaction->id)
            ->where('products_id', $productId)
            ->first();

        if (!$cartItem) {
            return redirect()->route('cart')->with('error', 'Produto não encontrado no carrinho.');
        }

        if ($action === 'increase') {
            $cartItem->quantity += 1;
        } elseif ($action === 'decrease') {
            $cartItem->quantity -= 1;
        }

        if ($cartItem->quantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->total_value = $cartItem->quantity * $cartItem->product->unit_price;
            $cartItem->save();
        }

        // Atualiza o total do carrinho
        $this->updateTransactionTotal($transaction);

        // Remove a transação se ficar vazia
        if ($transaction->items()->count() === 0) {
            $transaction->delete();
            return redirect()->route('cart')->with('message', 'Carrinho vazio, transação excluída!');
        }

        return redirect()->route('cart')->with('message', 'Quantidade atualizada com sucesso!');
    }

    public function purchaseError()
    {
        return response()->json([
            'error' => 'Erro na compra',
            'message' => 'Ocorreu um erro inesperado ao tentar processar sua compra. Por favor, tente novamente mais tarde.'
        ], 500);
    }

    private function getUserPendingTransaction($user)
    {
        return Transaction::where('status', 'pending')
                        ->whereHas('users', fn($query) => $query->where('users.id', $user->id)) // Esse método é usado para filtrar registros baseados em um relacionamento
                        ->first(); // sem a função anonima eu nao teria acesso a variavel $user
    }

    private function updateTransactionTotal($transaction)
    {
        $transaction->total_value = $transaction->items()->sum('total_value');
        $transaction->save();
    }
}
