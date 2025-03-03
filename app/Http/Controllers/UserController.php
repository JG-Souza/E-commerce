<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
   public function gerenciamento(){

    $response = Http::get(route('api.user.index'), [
        'page' => request()->query('page', 1),
    ]);

    if($response->successful()) {
        $data = $response->json();
        $users = $data['users'] ?? [];
        $totalPages = $data['total_pages'] ?? 1;
        $currentPage = request()->query('page', 1);

        // Criando a instância de paginação
        $usersPaginator = new Paginator($users, count($users), $totalPages, $currentPage);

        // Retornando para a view com a paginação
        return view('users_table', compact('usersPaginator'));
    }
    return abort(500, 'Erro ao buscar usuários.');

    // Sem consumir a API
    // $users = User::paginate(10);
    // return view('users_table', compact('users'));
   }
}
