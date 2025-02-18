<x-app-layout>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                    <span class="text-gray-500">R$ {{ number_format($product->unit_price, 2, ',', '.') }}</span>
                </div>

                <div class="flex gap-4">
                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->name }}" class="w-64 h-80 object-cover rounded-lg">

                    <div class="flex flex-col justify-between">
                        <p class="text-gray-700 mb-4">{{ $product->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Categoria: {{ $product->category }}</span>
                            <span class="text-gray-600">Quantidade: {{ $product->quantity }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
