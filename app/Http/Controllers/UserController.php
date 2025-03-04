<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function index()
   {
    $users = User::paginate(10);

    return view('users_table', compact('users'));
   }

   public function store(Request $request)
   {
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'logradouro' => $request->logradouro,
        'numero' => $request->numero,
        'bairro' => $request->bairro,
        'city' => $request->city,
        'state' => $request->state,
        'cep' => $request->cep,
        'country' => $request->country,
        'phone' => $request->phone,
        'birth_date' => $request->birth_date,
        'cpf' => $request->cpf,
        'balance' => $request->balance,
        'img_path' => $request->hasFile('img_path') ? $request->file('img_path')->store('images', 'public') : null,
    ]);

    return redirect()->route('users.index');
   }

   public function update(User $user, Request $request)
    {
        // Validação do arquivo
        $request->validate([
            'img_path' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Coleta todos os dados do request, exceto a imagem
        $data = $request->except('img_path');

        // Verifica se o arquivo de imagem foi enviado
        if ($request->hasFile('img_path') && $request->file('img_path')->isValid()) {
            // Armazena a imagem no diretório 'images' e retorna o caminho da imagem
            $imagePath = $request->file('img_path')->store('images', 'public');

            // Atualiza o caminho da imagem no banco de dados
            $data['img_path'] = $imagePath;
        }

        // Atualiza os dados do usuário no banco
        $user->update($data);

        return redirect()->route('users.index');
    }


   public function destroy(User $user)
   {
    $user->delete();

    return redirect()->route('users.index');
   }


}
