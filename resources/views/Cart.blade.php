<x-app-layout>
    @if ($cartItems)
        @if (session('message')) <!-- Está sendo usado Alpine.js para administrar o tempo de exibição e a animação da mensagem. Ele foi adicionado no layout (app) -->
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 4000)"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                class="max-w-4xl mx-auto mt-6"
            >
                <div class="flex items-center bg-green-100 border border-green-300 text-green-800 text-sm rounded-lg p-4" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-8 text-gray-900 w-full max-w-4xl mx-auto mt-6">
            <h2 class="text-2xl font-bold mb-6">Carrinho de Compras</h2>

            @foreach ($cartItems as $cartItem)
                <div class="bg-gray-100 rounded-lg p-6 flex items-center gap-6 mb-6">
                    <img src="{{ asset('storage/' . $cartItem->product->img_path) }}" alt="{{ $cartItem->product->name }}" class="w-24 h-24 object-cover rounded-lg">

                    <div class="flex-1">
                        <span class="text-xl font-semibold">{{ $cartItem->product->name }}</span>
                        <div class="text-gray-600">Valor Unitário: R$ {{ number_format($cartItem->product->unit_price, 2, ',', '.') }}</div>
                        <div class="text-gray-600">Valor Total: R$ {{ number_format($cartItem->total_value, 2, ',', '.') }}</div>
                    </div>

                    <!-- Controles de quantidade -->
                    <div class="flex items-center gap-2">
                        <form action="{{ route('cart.update', ['productId' => $cartItem->product->id, 'action' => 'decrease']) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-8 h-8 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">-</button>
                        </form>

                        <span class="px-3 py-1 border rounded text-center w-10">{{ $cartItem->quantity }}</span>

                        <form action="{{ route('cart.update', ['productId' => $cartItem->product->id, 'action' => 'increase']) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-8 h-8 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">+</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="mt-8 flex justify-between items-center">
                <span class="text-2xl font-bold">Total: R$ {{ number_format($transaction->total_value, 2, ',', '.') }}</span>
                <form action="/checkout" method="post">
                    @csrf
                    <input type="hidden" name="cartItems" value="{{ json_encode($cartItems) }}">
                    <button type="submit" class="bg-green-500 text-white px-8 py-3 rounded hover:bg-green-600">Comprar</button>
                </form>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center text-center bg-white p-10 rounded-lg shadow-md max-w-2xl mx-auto mt-12">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.3 5.2a1 1 0 001 1.3h11.6a1 1 0 001-1.3L17 13M7 13h10M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-700 mb-2">Seu carrinho está vazio</h2>
            <p class="text-gray-500 mb-6">Parece que você ainda não adicionou nenhum item. Que tal dar uma olhada em nossos produtos?</p>
            <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Ver Produtos</a>
        </div>
    @endif
</x-app-layout>
