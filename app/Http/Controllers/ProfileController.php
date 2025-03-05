<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Coleta todos os dados validados, exceto a imagem
        $data = $request->validated();

        // Verifica se há um arquivo de imagem no request
        if ($request->hasFile('img_path') && $request->file('img_path')->isValid()) {
            // Armazena a nova imagem e obtém o caminho
            $imagePath = $request->file('img_path')->store('images', 'public');

            // Remove a imagem antiga, se existir
            if ($user->img_path) {
                Storage::disk('public')->delete($user->img_path);
            }

            // Adiciona o novo caminho ao array de atualização
            $data['img_path'] = $imagePath;
        }

        $user->update($data);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'withdraw_amount' => ['required', 'numeric', 'min:1', 'max:' .auth()->user()->balance],
        ]);

        $user = auth()->user();
        $user->balance -= $validated['withdraw_amount'];
        $user->save();

        return back()->with('status', 'Saque realizado com sucesso!');
    }
}
