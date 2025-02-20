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

                <!-- Categoria logo após a descrição -->
                <div class="mt-3 mb-20">
                    <span class="text-sm text-gray-500">Categoria: <strong>{{ $product->category }}</strong></span>
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


                    <!-- Botão de adicionar ao carrinho e estoque com menos espaçamento -->
                    <div class="flex items-center gap-3">
    

                        <!-- Quantidade em estoque -->
                        <span class="text-gray-600 text-lg">Estoque: <strong>{{ $product->quantity }}</strong></span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
