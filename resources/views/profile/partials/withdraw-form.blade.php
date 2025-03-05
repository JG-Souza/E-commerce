<div class="container mx-auto px-4 py-6">
    <!-- Exibe o saldo atual do usuário -->
    <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Saldo Total') }}
        </h2>
        <p class="mt-1 text-xl text-gray-600">
            R$ {{ number_format($user->balance, 2, ',', '.') }}
        </p>
    </div>

    <!-- Seção de saque -->
    <div class="relative bg-white shadow-sm rounded-lg p-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Realizar Saque') }}
        </h2>

        <!-- Campo de valor do saque -->
         <form method="POST" action="{{ route('users.withdraw') }}" class="mt-4">
            @csrf
            <div>
                <label for="withdraw-amount" class="block text-sm font-medium text-gray-700">
                    {{ __('Informe o valor que deseja sacar') }}
                </label>
                <input
                    type="number"
                    id="withdraw-amount"
                    name="withdraw_amount"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    min="0"
                    max="{{ $user->balance }}"
                    placeholder="Valor do saque"
                    required
                >
                <p id="error-message" class="text-red-500 text-xs mt-1 hidden">
                    {{ __('O valor do saque não pode ser maior que o saldo disponível.') }}
                </p>
            </div>

            <!-- Botão para realizar o saque -->
            <div class="mt-6 flex">
                <button
                    id="withdraw-btn"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    onclick="performWithdraw()"
                >
                    Realizar Saque
                </button>
            </div>
        </form>

    </div>
</div>

