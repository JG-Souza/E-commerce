<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check(); // Permite apenas se o admin estiver autenticado
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Admin::class)->ignore(Auth::guard('admin')->user()->id), // Usando o guard 'admin'
            ],
            'password' => ['nullable', 'string', 'confirmed'],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:10'],
            'bairro' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'cep' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'birth_date' => ['required', 'date', 'before:today'], // Data de nascimento obrigatória e precisa ser antes de hoje
            'cpf' => ['required', 'string', Rule::unique(Admin::class)->ignore(Auth::guard('admin')->user()->id)], // Usando o guard 'admin'
            'img_path' => ['image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ];
    }
}
