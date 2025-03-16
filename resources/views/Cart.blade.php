<x-app-layout>
@if ($cartItems)
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
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
            <span class="text-gray-600">Quantidade: {{ $cartItem->quantity }}</span>
        </div>
        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Remover</button>
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
<span>Você não possui carrinho</span>
@endif

</x-app-layout>

