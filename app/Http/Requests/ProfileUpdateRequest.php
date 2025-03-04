<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
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
                Rule::unique(User::class)->ignore($this->user()->id),
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
            'cpf' => ['required', 'string', Rule::unique(User::class)->ignore($this->user()->id)], // CPF deve ter 11 dígitos únicos
            'balance' => ['nullable', 'numeric', 'min:0'], // Saldo opcional, mas não pode ser negativo
            'img_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'], // Avatar opcional, apenas JPEG/PNG, até 2MB
        ];
    }
}
