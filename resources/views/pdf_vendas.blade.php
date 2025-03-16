<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Relatório de Vendas - Últimos 30 Dias</h2>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Total</th>
                <th>Comprador</th>
                <th>Vendedor</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($vendas as $venda)
                <tr>
                    <td colspan="8" style="background-color: #ddd;">
                        <strong>{{ \Carbon\Carbon::parse($venda->transaction->date)->format('d/m/Y') }}</strong> -
                        Total: R$ {{ number_format($venda->transaction->total_value, 2, ',', '.') }}
                    </td>
                </tr>
                @foreach ($venda->transaction->items as $item)
                    <tr>
                        <td></td>

                        <td>{{ $item->product->name}}</td>
                        <td>{{ $item->product->category}}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>R$ {{ number_format($item->product->unit_price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->total_value, 2, ',', '.') }}</td>
                        <td>{{ optional($venda->transaction->customer->first())->name}}</td>
                        <td>{{ $item->product->user->name}}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
