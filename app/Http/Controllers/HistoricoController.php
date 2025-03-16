<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RelationTransactionUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class HistoricoController extends Controller
{
    public function vendas()
    {
            if (Auth::guard('web')->check()) {
                $user = Auth::user();

            $vendas = RelationTransactionUser::where("users_id", $user->id)
                ->where("role", "seller")
                ->with(['transaction.items.product'])
                ->paginate(4);

            foreach ($vendas as $venda) {
                // Filtra apenas os itens vendidos pelo usuário
                $venda->transaction->items = $venda->transaction->items->filter(function ($item) use ($user) {
                    return $item->product->users_id == $user->id;
                });

                // Recalcula o total da venda considerando apenas esses itens
                $venda->transaction->total_value = $venda->transaction->items->sum(function ($item) {
                    return $item->total_value;
                });
            }

            return view('historico_vendas', compact('vendas'));
        }

        // condição para admin
            $vendas = RelationTransactionUser::where("role", "seller")
            ->with(['transaction.items.product'])
            ->paginate(4);

            return view('admin.historico_vendas', compact('vendas'));
    }

    public function gerarPdfVendas()
    {
        $dataLimite = Carbon::now()->subDays(30);
        $user = Auth::user();

        // Se for admin, mostra todas as vendas
        if (Auth::guard('admin')->check()) {
            $vendas = RelationTransactionUser::where("role", "seller")
                ->whereHas('transaction', function ($query) use ($dataLimite) {
                    $query->where('date', '>=', $dataLimite);
                })
                ->with(['transaction.items.product', 'transaction.customer'])
                ->get();

        } else {
            // Se for usuário comum, mostra apenas suas vendas
            $vendas = RelationTransactionUser::where("users_id", $user->id)
                ->where("role", "seller")
                ->whereHas('transaction', function ($query) use ($dataLimite) {
                    $query->where('date', '>=', $dataLimite);
                })
                ->with(['transaction.items.product', 'transaction.customer'])
                ->get();

            // Filtra apenas os itens vendidos pelo usuário
            foreach ($vendas as $venda) {
                $venda->transaction->items = $venda->transaction->items->filter(function ($item) use ($user) {
                    return $item->product->users_id == $user->id;
                });

                // Recalcula o total da venda considerando apenas esses itens
                $venda->transaction->total_value = $venda->transaction->items->sum(function ($item) {
                    return $item->total_value;
                });
            }
        }

        $pdf = Pdf::loadView('pdf_vendas', compact('vendas'));

        return $pdf->stream('historico_vendas.pdf');
    }

    public function compras()
    {
        $user = Auth::user();

        $compras = RelationTransactionUser::where("users_id", $user->id)
            ->where("role", "customer")
            ->with(['transaction.items.product']) // carrega o relacionamento
            ->paginate(4);

        return view('historico_compras', compact('compras'));
    }

    public function gerarPdfCompras()
    {
        $dataLimite = Carbon::now()->subDays(30);
        $user = Auth::user();

        $compras = RelationTransactionUser::where("users_id", $user->id)
            ->where("role", "customer")
            ->whereHas('transaction', function ($query) use ($dataLimite) {
                $query->where('date', '>=', $dataLimite);
            })
            ->with(['transaction.items.product'])
            ->get();

        $pdf = Pdf::loadView('pdf_compras', compact('compras'));

        return $pdf->stream('historico_compras.pdf');
    }

}
