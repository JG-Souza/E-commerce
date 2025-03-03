<x-app-layout>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
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
                    @foreach ($users as $user)
                    <tr class="border-b border-gray-200">
                        <td class="px-6 py-3 text-sm text-center">{{ $user->id }}</td>
                        <td class="px-6 py-3 text-sm text-center">{{ $user->name }}</td>
                        <td class="px-6 py-3 text-sm text-center">{{ $user->email }}</td>
                        <td class="px-6 py-3 text-sm text-center">
                            <div class="flex justify-center space-x-4">
                                <!-- Ícone View (olho) -->
                        <button>
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Ícone Edit (lápis) -->
                        <button>
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- Ícone Delete (lixeira) -->
                        <button>
                            <i class="fas fa-trash-alt"></i>
                        </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inicio da Paginação -->
    <div class="flex justify-center mt-12">
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>
        <!-- Fim da Paginação -->
</x-app-layout>
