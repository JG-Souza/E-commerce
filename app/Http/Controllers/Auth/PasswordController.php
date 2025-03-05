<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // Verifica qual guard usar (admin ou usuário)
        if ($request->is('admin/*')) {
            $guard = Auth::guard('admin');
            $user = $guard->user(); // Admin autenticado
        } else {
            $guard = Auth::guard('web');
            $user = $guard->user(); // Usuário comum autenticado
        }

        // Validação para a senha atual
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    // Valida se a senha fornecida é a correta para o admin ou usuário
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }
            ],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Atualiza a senha
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

}
