<x-app-layout>
    <x-slot name="header">
    <form method="GET" action="{{ route('products.search') }}" class="flex justify-center items-center mb-4 rounded-lg">
            <select name="categoria" id="categoria" class="bg-blue-600 text-white px-3 py-2 text-sm border-r">
                <option value="" disabled selected>Categoria</option> <!-- Placeholder -->
                <option value="Aventura">Aventura</option>
                <option value="Romance">Romance</option>
                <option value="Ficcao">Ficção</option>
                <option value="Anime">Anime</option>
                <option value="Classico">Clássico</option>
            </select>

            <div class="flex w-full max-w-3xl">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar..."
                    class="flex-grow text-black px-3 py-2 text-sm focus:outline-none">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 flex items-center justify-center">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12 justify-items-center">

                <!-- Cards -->
                @foreach ($products as $product)
                <div class="bg-white shadow-sm rounded-lg p-4 text-gray-900 w-64 h-[400px] flex flex-col">
                    <!-- Imagem clicável -->
                    <a href="{{ route('admin.produto.show', ['id' => $product->id]) }}">
                        <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->name }}" class="w-full h-60 object-cover rounded-lg">
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
            {{ $products->links('vendor.pagination.tailwind') }}
        </div>
        <!-- Fim da Paginação -->

    </div>
</x-app-layout>
