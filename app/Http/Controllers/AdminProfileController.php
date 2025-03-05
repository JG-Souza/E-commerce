<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Admin;

class AdminProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin_profile.edit', [
            'admin' => Auth::guard('admin')->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(AdminProfileUpdateRequest $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        // Coleta todos os dados validados, exceto a imagem
        $data = $request->validated();

        // Verifica se há um arquivo de imagem no request
        if ($request->hasFile('img_path') && $request->file('img_path')->isValid()) {
            // Armazena a nova imagem e obtém o caminho
            $imagePath = $request->file('img_path')->store('images', 'public');

            // Remove a imagem antiga, se existir
            if ($admin->img_path) {
                Storage::disk('public')->delete($admin->img_path);
            }

            // Adiciona o novo caminho ao array de atualização
            $data['img_path'] = $imagePath;
        }

        $admin->update($data);

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        // Validação da senha
        $request->validateWithBag('adminDeletion', [
            'password' => ['required', function ($attribute, $value, $fail) use ($admin) {
                if (!\Hash::check($value, $admin->password)) {
                    return $fail(__('The password is incorrect.'));
                }
            }],
        ]);

        Auth::guard('admin')->logout();

        $admin->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }
}
