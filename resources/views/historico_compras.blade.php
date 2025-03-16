<x-app-layout>
<div class="flex justify-end mb-4">
    <a href="{{ route('user.compras.pdf') }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600">
        Gerar PDF
    </a>
</div>
    <div class="container mx-auto p-6">
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Data da Compra</th>
                        <th class="px-4 py-2 text-left">Nome do Produto</th>
                        <th class="px-4 py-2">Foto do Produto</th>
                        <th class="px-4 py-2 text-center">Quantidade</th>
                        <th class="px-4 py-2 text-right">Valor Unitário</th>
                        <th class="px-4 py-2 text-right">Valor Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($compras as $compra)
                        @php
                            $totalCompra = 0;
                        @endphp
                        <tr class="bg-gray-200 font-semibold">
                            <td class="px-4 py-3" colspan="6">
                                <strong>{{ \Carbon\Carbon::parse($compra->transaction->date)->format('d/m/Y') }}</strong> -
                                Total: R$ {{ number_format($compra->transaction->total_value, 2, ',', '.') }}
                            </td>
                        </tr>

                        @foreach ($compra->transaction->items as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-3"></td> <!-- Deixa a coluna da Data vazia para os itens -->
                                <td class="px-4 py-3 text-gray-700">{{ $item->product->name }}</td>
                                <td class="px-4 py-3 flex justify-center">
                                    <img src="{{ asset('storage/' . $item->product->img_path) }}"
                                         alt="Produto" class="w-16 h-16 object-cover rounded-md border">
                                </td>
                                <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right">R$ {{ number_format($item->product->unit_price, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-semibold">R$ {{ number_format($item->total_value, 2, ',', '.') }}</td>
                            </tr>
                            @php
                                $totalCompra += $item->total_value;
                            @endphp
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Nenhuma compra encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $compras->links() }}
</x-app-layout>
