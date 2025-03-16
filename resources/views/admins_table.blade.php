<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <button onclick="document.getElementById('modalStore').showModal()" class="cursor-pointer">
        Criar
    </button>
    <div class="flex justify-center mt-8">
        <div class="overflow-hidden max-w-4xl w-full bg-white shadow-md rounded-lg">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">Nome</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                    <tr class="border-b border-gray-200">
                        <td class="px-6 py-3 text-sm text-center">{{ $admin->id }}</td>
                        <td class="px-6 py-3 text-sm text-center">{{ $admin->name }}</td>
                        <td class="px-6 py-3 text-sm text-center">{{ $admin->email }}</td>
                        <td class="px-6 py-3 text-sm text-center">
                            <div class="flex justify-center space-x-4">
                                <!-- Botões para abrir os modais -->
                                <button onclick="document.getElementById('modalView-{{ $admin->id }}').showModal()" class="cursor-pointer">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button onclick="document.getElementById('modalUpdate-{{ $admin->id }}').showModal()" class="cursor-pointer">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button onclick="document.getElementById('modalDelete-{{ $admin->id }}').showModal()" class="cursor-pointer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>


                    <!-- Modal View -->
                    <dialog id="modalView-{{ $admin->id }}" class="bg-white rounded-lg w-1/3 p-6 relative shadow-lg">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Detalhes do Administrador</h2>
                        </div>

                        <!-- Modal Content -->
                        <div class="mb-4 space-y-2">
                            <p><strong>ID:</strong> {{ $admin->id }}</p>
                            <p><strong>Nome:</strong> {{ $admin->name }}</p>
                            <p><strong>Email:</strong> {{ $admin->email }}</p>
                            <p><strong>Senha:</strong> ********</p>
                            <p><strong>Logradouro:</strong> {{ $admin->logradouro }}</p>
                            <p><strong>Número:</strong> {{ $admin->numero }}</p>
                            <p><strong>Bairro:</strong> {{ $admin->bairro }}</p>
                            <p><strong>Cidade:</strong> {{ $admin->city }}</p>
                            <p><strong>Estado:</strong> {{ $admin->state }}</p>
                            <p><strong>CEP:</strong> {{ $admin->cep }}</p>
                            <p><strong>País:</strong> {{ $admin->country }}</p>
                            <p><strong>Telefone:</strong> {{ $admin->phone }}</p>
                            <p><strong>Data de Nascimento:</strong> {{ \Carbon\Carbon::parse($admin->birth_date)->format('d/m/Y') }}</p>
                            <p><strong>CPF:</strong> {{ $admin->cpf }}</p>
                            <p><strong>Imagem de Perfil:</strong></p>
                            @if($admin->img_path)
                            <img src="{{ asset('storage/' . $admin->img_path) }}" alt="Imagem de Perfil" class="w-24 h-24 rounded-full border">
                            @else
                            <img src="{{ asset('storage/img.jpg') }}" alt="" class="w-24 h-24 rounded-full border">
                            @endif
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex justify-end">
                            <button onclick="document.getElementById('modalView-{{ $admin->id }}').close()" class="px-4 py-2 bg-blue-500 text-white rounded">Fechar</button>
                        </div>
                    </dialog>


                    <!-- Modal Update -->
                    <dialog id="modalUpdate-{{ $admin->id }}" class="bg-white rounded-lg w-1/3 p-6 relative shadow-lg">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Editar Administrador</h2>
                        </div>

                        <!-- Modal Content -->
                        <form action="{{ route('admins.update', $admin->id) }}" method="POST" class="mb-4" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <!-- Nome -->
                            <label for="name">Nome:</label>
                            <input type="text" name="name" value="{{ $admin->name }}" class="border rounded px-2 py-1 w-full">

                            <!-- Email -->
                            <label for="email">Email:</label>
                            <input type="email" name="email" value="{{ $admin->email }}" class="border rounded px-2 py-1 w-full">

                            <!-- Senha -->
                            <label for="password">Senha:</label>
                            <input type="password" name="password" value="{{ $admin->password }}" class="border rounded px-2 py-1 w-full">

                            <!-- Logradouro -->
                            <label for="logradouro">Logradouro:</label>
                            <input type="text" name="logradouro" value="{{ $admin->logradouro }}" class="border rounded px-2 py-1 w-full">

                            <!-- Número -->
                            <label for="numero">Número:</label>
                            <input type="text" name="numero" value="{{ $admin->numero }}" class="border rounded px-2 py-1 w-full">

                            <!-- Bairro -->
                            <label for="bairro">Bairro:</label>
                            <input type="text" name="bairro" value="{{ $admin->bairro }}" class="border rounded px-2 py-1 w-full">

                            <!-- Cidade -->
                            <label for="city">Cidade:</label>
                            <input type="text" name="city" value="{{ $admin->city }}" class="border rounded px-2 py-1 w-full">

                            <!-- Estado -->
                            <label for="state">Estado:</label>
                            <input type="text" name="state" value="{{ $admin->state }}" class="border rounded px-2 py-1 w-full">

                            <!-- CEP -->
                            <label for="cep">CEP:</label>
                            <input type="text" name="cep" value="{{ $admin->cep }}" class="border rounded px-2 py-1 w-full">

                            <!-- País -->
                            <label for="country">País:</label>
                            <input type="text" name="country" value="{{ $admin->country }}" class="border rounded px-2 py-1 w-full">

                            <!-- Telefone -->
                            <label for="phone">Telefone:</label>
                            <input type="tel" name="phone" value="{{ $admin->phone }}" class="border rounded px-2 py-1 w-full">

                            <!-- Data de Nascimento -->
                            <label for="birth_date">Data de Nascimento:</label>
                            <input type="date" name="birth_date" value="{{ \Carbon\Carbon::parse($admin->birth_date)->format('Y-m-d') }}" class="border rounded px-2 py-1 w-full">

                            <!-- CPF -->
                            <label for="cpf">CPF:</label>
                            <input type="text" name="cpf" value="{{ $admin->cpf }}" class="border rounded px-2 py-1 w-full">

                            <!-- Imagem -->
                            <label for="img_path">Imagem de Perfil:</label>
                            <input type="file" name="img_path" class="border rounded px-2 py-1 w-full">

                            <div class="flex justify-end mt-4">
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Salvar</button>
                                <button type="button" onclick="document.getElementById('modalUpdate-{{ $admin->id }}').close()" class="px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
                            </div>
                        </form>
                    </dialog>

                    <!-- Modal Delete -->
                    <dialog id="modalDelete-{{ $admin->id }}" class="bg-white rounded-lg w-1/3 p-6 relative shadow-lg">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Excluir Administrador</h2>
                        </div>

                        <!-- Modal Content -->
                        <div class="mb-4">
                            <p>Tem certeza que deseja excluir o administrador <strong>{{ $admin->name }}</strong>?</p>
                        </div>

                        <!-- Modal Footer -->
                        <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="flex justify-end space-x-4">
                            @csrf
                            @method('delete')

                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Excluir</button>
                            <button type="button" onclick="document.getElementById('modalDelete-{{ $admin->id }}').close()" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</button>
                        </form>
                    </dialog>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-center text-gray-500">Nenhum administrador encontrado.</td>
                        </tr>
                    @endforelse

                    <!-- Modal Store -->
                    <dialog id="modalStore" class="bg-white rounded-lg w-1/3 p-6 relative shadow-lg">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Criar Administrador</h2>
                        </div>

                        <!-- Modal Content -->
                        <form action="{{ route('admins.store') }}" method="POST" class="mb-4" enctype="multipart/form-data">
                            @csrf

                            <!-- Campo hidden para created_by -->
                            <input type="hidden" name="created_by" value="{{ auth()->guard('admin')->user()->id }}">

                            <!-- Nome -->
                            <label for="name">Nome:</label>
                            <input type="text" name="name" class="border rounded px-2 py-1 w-full" required>

                            <!-- Email -->
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="border rounded px-2 py-1 w-full" required>

                            <!-- Senha -->
                            <label for="password">Senha:</label>
                            <input type="password" name="password" class="border rounded px-2 py-1 w-full" required>

                            <!-- Logradouro -->
                            <label for="logradouro">Logradouro:</label>
                            <input type="text" name="logradouro" class="border rounded px-2 py-1 w-full" required>

                            <!-- Número -->
                            <label for="numero">Número:</label>
                            <input type="text" name="numero" class="border rounded px-2 py-1 w-full" required>

                            <!-- Bairro -->
                            <label for="bairro">Bairro:</label>
                            <input type="text" name="bairro" class="border rounded px-2 py-1 w-full" required>

                            <!-- Cidade -->
                            <label for="city">Cidade:</label>
                            <input type="text" name="city" class="border rounded px-2 py-1 w-full" required>

                            <!-- Estado -->
                            <label for="state">Estado:</label>
                            <input type="text" name="state" class="border rounded px-2 py-1 w-full" required>

                            <!-- CEP -->
                            <label for="cep">CEP:</label>
                            <input type="text" name="cep" class="border rounded px-2 py-1 w-full" required>

                            <!-- País -->
                            <label for="country">País:</label>
                            <input type="text" name="country" class="border rounded px-2 py-1 w-full" required>

                            <!-- Telefone -->
                            <label for="phone">Telefone:</label>
                            <input type="tel" name="phone" class="border rounded px-2 py-1 w-full" required>

                            <!-- Data de Nascimento -->
                            <label for="birth_date">Data de Nascimento:</label>
                            <input type="date" name="birth_date" class="border rounded px-2 py-1 w-full" required>

                            <!-- CPF -->
                            <label for="cpf">CPF:</label>
                            <input type="text" name="cpf" class="border rounded px-2 py-1 w-full" required>

                            <!-- Imagem (img_path) -->
                            <label for="img_path">Imagem de Perfil:</label>
                            <input type="file" name="img_path" class="border rounded px-2 py-1 w-full">


                            <!-- Modal Footer -->
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Salvar</button>
                                <button type="button" onclick="document.getElementById('modalStore').close()" class="px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
                            </div>
                        </form>
                    </dialog>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
