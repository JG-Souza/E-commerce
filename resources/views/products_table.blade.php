<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <button onclick="document.getElementById('modalStore').showModal()" class="cursor-pointer">
        Criar Produto
    </button>

    <!-- Modal Store -->
    <dialog id="modalStore" class="bg-white rounded-lg w-1/3 p-6 shadow-lg">
        <h2 class="text-xl font-semibold">Criar Novo Produto</h2>
        <form action="{{ route('store.products') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Nome:</label>
            <input type="text" name="name" required class="border rounded px-2 py-1 w-full">

            <label>Descrição:</label>
            <input type="text" name="description" required class="border rounded px-2 py-1 w-full">

            <label>Categoria:</label>
            <select name="category" required class="border rounded px-2 py-1 w-full">
                <option value="" disabled selected>Selecione uma categoria</option>
                <option value="Romance">Romance</option>
                <option value="Ficção">Ficção</option>
                <option value="Suspense">Suspense</option>
                <option value="Terror">Terror</option>
                <option value="Aventura">Aventura</option>
            </select>

            <label>Preço Unitário:</label>
            <input type="number" step="0.01" name="unit_price" required class="border rounded px-2 py-1 w-full">

            <label>Quantidade:</label>
            <input type="number" name="quantity" required class="border rounded px-2 py-1 w-full">

            <!-- Input para upload de imagem -->
            <label>Imagem do Produto:</label>
            <input type="file" name="img_path" accept="image/*" required class="border rounded px-2 py-1 w-full">

            <div class="flex justify-between mt-4">
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Salvar</button>
                <button type="button" onclick="document.getElementById('modalStore').close()" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</button>
            </div>
        </form>
    </dialog>


    <div class="flex justify-center mt-8">
        <div class="overflow-hidden max-w-4xl w-full bg-white shadow-md rounded-lg">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">Usuário</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">Preço Unitário</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">Quantidade</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr class="border-b border-gray-200">
                        <td class="px-6 py-3 text-sm text-center">{{ $product->id }}</td>
                        <td class="px-6 py-3 text-sm text-center">{{ $product->user->name }}</td>
                        <td class="px-6 py-3 text-sm text-center">{{ $product->unit_price }}</td>
                        <td class="px-6 py-3 text-sm text-center">{{ $product->quantity }}</td>
                        <td class="px-6 py-3 text-sm text-center">
                            <div class="flex justify-center space-x-4">
                                <button onclick="document.getElementById('modalView-{{ $product->id }}').showModal()" class="cursor-pointer">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="document.getElementById('modalUpdate-{{ $product->id }}').showModal()" class="cursor-pointer">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="document.getElementById('modalDelete-{{ $product->id }}').showModal()" class="cursor-pointer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal View -->
                    <dialog id="modalView-{{ $product->id }}" class="bg-white rounded-lg w-1/3 p-6 shadow-lg">
                        <h2 class="text-xl font-semibold">Detalhes do Produto</h2>
                        @if($product->img_path)
                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="Imagem do Produto" class="w-24 h-24 rounded-full border">
                        @else
                            <img src="{{ asset('storage/img.jpg') }}" alt="Imagem Padrão" class="w-24 h-24 rounded-full border">
                        @endif
                        <p><strong>Nome:</strong> {{ $product->name }}</p>
                        <p><strong>Descrição:</strong> {{ $product->description }}</p>
                        <p><strong>Categoria:</strong> {{ $product->category }}</p>
                        <p><strong>Preço Unitário:</strong> {{ $product->unit_price }}</p>
                        <p><strong>Quantidade:</strong> {{ $product->quantity }}</p>
                        <button onclick="document.getElementById('modalView-{{ $product->id }}').close()" class="px-4 py-2 bg-blue-500 text-white rounded">Fechar</button>
                    </dialog>

                    <!-- Modal Update -->
                    <dialog id="modalUpdate-{{ $product->id }}" class="bg-white rounded-lg w-1/3 p-6 shadow-lg">
                        <h2 class="text-xl font-semibold">Editar Produto</h2>
                        <form action="{{ route('update.products', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <label>Nome:</label>
                            <input type="text" name="name" value="{{ $product->name }}" class="border rounded px-2 py-1 w-full">
                            <label>Descrição:</label>
                            <input type="text" name="description" value="{{ $product->description }}" class="border rounded px-2 py-1 w-full">
                            <label>Categoria:</label>
                            <select name="category" class="border rounded px-2 py-1 w-full">
                                <option value="" disabled>Selecione uma categoria</option>
                                <option value="Romance" {{ $product->category == 'Romance' ? 'selected' : '' }}>Romance</option>
                                <option value="Ficção" {{ $product->category == 'Ficção' ? 'selected' : '' }}>Ficção</option>
                                <option value="Suspense" {{ $product->category == 'Suspense' ? 'selected' : '' }}>Suspense</option>
                                <option value="Terror" {{ $product->category == 'Terror' ? 'selected' : '' }}>Terror</option>
                                <option value="Aventura" {{ $product->category == 'Aventura' ? 'selected' : '' }}>Aventura</option>
                            </select>
                            <label>Preço Unitário:</label>
                            <input type="text" name="unit_price" value="{{ $product->unit_price }}" class="border rounded px-2 py-1 w-full">
                            <label>Quantidade:</label>
                            <input type="text" name="quantity" value="{{ $product->quantity }}" class="border rounded px-2 py-1 w-full">
                            <!-- Input para upload de imagem -->
                            <label>Imagem do Produto:</label>
                            <input type="file" name="img_path" accept="image/*" class="border rounded px-2 py-1 w-full">

                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Salvar</button>
                            <button type="button" onclick="document.getElementById('modalUpdate-{{ $product->id }}').close()" class="px-4 py-2 bg-blue-500 text-white rounded">Fechar</button>
                        </form>
                    </dialog>

                    <!-- Modal Delete -->
                    <dialog id="modalDelete-{{ $product->id }}" class="bg-white rounded-lg w-1/3 p-6 shadow-lg">
                        <h2 class="text-xl font-semibold">Excluir Produto</h2>
                        <p>Tem certeza que deseja excluir o produto <strong>{{ $product->name }}</strong>?</p>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Excluir</button>
                            <button type="button" onclick="document.getElementById('modalDelete-{{ $product->id }}').close()" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</button>
                        </form>
                    </dialog>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-center text-gray-500">Nenhum produto encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
