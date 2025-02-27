<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-8 flex gap-8">
            <!-- Imagem do produto -->
            <img src="{{ asset($product->img_path) }}"
                 alt="{{ $product->name }}"
                 class="w-64 h-80 object-cover rounded-lg">

            <!-- Informações do produto -->
            <div class="flex flex-col flex-1">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $product->name }}</h3>
                <p class="text-gray-700 mt-3">{{ $product->description }}</p>

                <div class="mt-3">
                    <span class="text-sm text-gray-500">Categoria: <strong>{{ $product->category }}</strong></span>
                </div>

                <div class="mt-1">
                    <span class="text-sm text-gray-500">Anunciante: <strong>{{ $product->user->name }}</strong></span>
                </div>
                <div class="mt-1 mb-20">
                    <span class="text-sm text-gray-500">Telefone: <strong>{{ $product->user->phone }}</strong></span>
                </div>

                <!-- Seção final: preço, botão e estoque -->
                <div class="flex items-center justify-between mt-24">
                    <!-- Preço com preço riscado -->
                    <div class="mt-2">
                        <span class="text-lg text-gray-500 line-through">
                            R$ {{ number_format($product->unit_price * 1.5, 2, ',', '.') }}
                        </span>
                        <span class="text-2xl text-blue-600 font-semibold ml-2">
                            R$ {{ number_format($product->unit_price, 2, ',', '.') }}
                        </span>
                    </div>

                    <!-- Botão de adicionar ao carrinho e dropdown de quantidade -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center gap-3 flex-row">
                            @csrf



                            <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md flex items-center gap-2 hover:bg-blue-700 transition">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 5m12 0a2 2 0 100-4 2 2 0 000 4zm-10 0a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                                <span>Adicionar</span>
                            </button>

                             <!-- Dropdown para selecionar quantidade -->
                             <select name="quantity" id="quantity" class="bg-white border text-sm px-4 py-2 rounded-lg">
                             <option value="" disabled selected>Quantidade</option> <!-- Placeholder -->
                                @for ($i = 1; $i <= $product->quantity; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
