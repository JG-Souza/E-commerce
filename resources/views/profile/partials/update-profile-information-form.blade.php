<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <div>
        <x-input-label for="logradouro" :value="__('Logradouro')" />
        <x-text-input id="logradouro" name="logradouro" type="text" class="mt-1 block w-full" :value="old('logradouro', $user->logradouro)" required />
        <x-input-error class="mt-2" :messages="$errors->get('logradouro')" />
    </div>

    <div>
        <x-input-label for="numero" :value="__('Número')" />
        <x-text-input id="numero" name="numero" type="text" class="mt-1 block w-full" :value="old('numero', $user->numero)" required />
        <x-input-error class="mt-2" :messages="$errors->get('numero')" />
    </div>

    <div>
        <x-input-label for="bairro" :value="__('Bairro')" />
        <x-text-input id="bairro" name="bairro" type="text" class="mt-1 block w-full" :value="old('bairro', $user->bairro)" required />
        <x-input-error class="mt-2" :messages="$errors->get('bairro')" />
    </div>

    <div>
        <x-input-label for="city" :value="__('Cidade')" />
        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" required />
        <x-input-error class="mt-2" :messages="$errors->get('city')" />
    </div>

    <div>
        <x-input-label for="state" :value="__('Estado')" />
        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $user->state)" required />
        <x-input-error class="mt-2" :messages="$errors->get('state')" />
    </div>

    <div>
        <x-input-label for="cep" :value="__('CEP')" />
        <x-text-input id="cep" name="cep" type="text" class="mt-1 block w-full" :value="old('cep', $user->cep)" required />
        <x-input-error class="mt-2" :messages="$errors->get('cep')" />
    </div>

    <div>
        <x-input-label for="country" :value="__('País')" />
        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" required />
        <x-input-error class="mt-2" :messages="$errors->get('country')" />
    </div>

    <div>
        <x-input-label for="phone" :value="__('Telefone')" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <div>
        <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
        <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
    </div>

    <div>
        <x-input-label for="cpf" :value="__('CPF')" />
        <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full" :value="old('cpf', $user->cpf)" required />
        <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
    </div>

    <div>
        <x-input-label for="balance" :value="__('Saldo')" />
        <x-text-input id="balance" name="balance" type="number" step="0.01" class="mt-1 block w-full" :value="old('balance', $user->balance)" />
        <x-input-error class="mt-2" :messages="$errors->get('balance')" />
    </div>

    <div>
        <x-input-label for="img_path" :value="__('Profile Picture')" />

        <!-- Campo de Upload -->
        <input type="file" id="img_path" name="img_path" class="mt-1 block w-full">

        <!-- Exibir imagem atual -->
        @if ($user->img_path)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $user->img_path) }}" alt="Profile Picture" class="h-20 w-20 rounded-full">
            </div>
        @endif

        <x-input-error class="mt-2" :messages="$errors->get('img_path')" />
    </div>


    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('Saved.') }}</p>
        @endif
    </div>
</form>
