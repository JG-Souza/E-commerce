<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index()
    {
        $loggedInAdminId = auth()->guard('admin')->user()->id;

        $admins = Admin::where('created_by', $loggedInAdminId)
                    ->where('id', '!=', $loggedInAdminId)
                    ->paginate(10);

        return view('admins_table', compact('admins'));
    }


    public function store(Request $request)
    {
        Admin::create([
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
            'created_by' => auth()->guard('admin')->user()->id,
        ]);

        return redirect()->route('admins.index');
    }

    public function update(Admin $admin, Request $request)
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
        $admin->update($data);

        return redirect()->route('admins.index');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admins.index');
    }


}
