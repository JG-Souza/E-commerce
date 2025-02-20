<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center mb-4">
            <div class="flex gap-2 w-full max-w-3xl">
                <input type="text" placeholder="Pesquisar..." class="border w-full rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button class="bg-black text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">Filtros</button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12 justify-items-center">

                <!-- Cards -->
                @foreach ($products as $product)
                <div class="bg-white shadow-sm rounded-lg p-4 text-gray-900 w-64 h-[400px] flex flex-col">
                    <!-- Imagem clicável -->
                    <a href="{{ route('admin.produto.show', ['id' => $product->id]) }}">
                        <img src="{{ asset($product->img_path) }}" alt="{{ $product->name }}" class="w-full h-60 object-cover rounded-lg">
                    </a>

                    <div class="text-center mt-3 flex-grow">
                        <!-- Título clicável -->
                        <a href="{{ route('admin.produto.show', ['id' => $product->id]) }}" class="text-lg font-semibold hover:underline">
                            {{ $product->name }}
                        </a>
                        <div class="mt-2">
                        <span class="text-lg text-gray-500 line-through">
                            R$ {{ number_format($product->unit_price * 1.5, 2, ',', '.') }}
                        </span>
                        <span class="text-2xl text-blue-600 font-semibold ml-2">
                            R$ {{ number_format($product->unit_price, 2, ',', '.') }}
                        </span>
                        </div>
                    </div>

                </div>
                @endforeach

            </div>
        </div>

        <!-- Inicio da Paginação -->
        <div class="flex justify-center mt-12">
            <ul class="flex items-center space-x-2">
                <li>
                    <a href="#" class="px-3 py-2 border rounded-lg text-gray-600 hover:bg-gray-200">Anterior</a>
                </li>

                <li>
                    <a href="#" class="px-3 py-2 border rounded-lg bg-blue-600 text-white">1</a>
                </li>
                <li>
                    <a href="#" class="px-3 py-2 border rounded-lg text-gray-600 hover:bg-gray-200">2</a>
                </li>
                <li>
                    <a href="#" class="px-3 py-2 border rounded-lg text-gray-600 hover:bg-gray-200">3</a>
                </li>

                <li>
                    <a href="#" class="px-3 py-2 border rounded-lg text-gray-600 hover:bg-gray-200">Próximo</a>
                </li>
            </ul>
        </div>
        <!-- Fim da Paginação -->

    </div>
</x-app-layout>
