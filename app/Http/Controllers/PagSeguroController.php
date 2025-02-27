<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use App\Http\Controllers\CartController;

class PagSeguroController extends Controller
{
    public function createCheckout(Request $request)
    {
        $url = config('services.pagseguro.checkout');
        $token = config('services.pagseguro.token');

        $cartItems = json_decode($request->cartItems, true);

        // entender as funções anonimas
        $items = array_map(fn($item) => [
            'name' => $item['product']['name'],
            'quantity' => $item['quantity'],
            'unit_amount' => $item['product']['unit_price'] * 100
        ], $cartItems);



        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-type' => 'application/json'
        ])
        ->withoutVerifying()
        ->post($url, [
            'reference_id' => uniqid(), // Não entendi
            'items' => $items // Não entendi
        ]);


        // registro na tabela de transação, no meu caso, tenho que alterar o status da transação de pendente para completed
        if($response->successful()){
            $user = Auth::user();

            // Busca a transação "pendente" associada ao carrinho do usuário
            $transaction = Transaction::where('status', 'pending')
            ->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->first();

            if($transaction){
                foreach ($transaction->items as $item){
                    $product = $item->product;

                    $anunciante = $product->user;

                    $product->quantity -= $item->quantity;
                    $product->save();


                    if($anunciante) {
                        $anunciante->increment('balance', $product->unit_price * $item->quantity);
                    }
                }
                $transaction->status = 'completed';
                $transaction->save();
            }

            $pay_link = data_get($response->json(), 'links.1.href');
            // A quantidade do produto está sendo subtraída do estoque?

            return redirect()->away($pay_link);
        }

        return redirect('erro-pagamento');
    }
}
