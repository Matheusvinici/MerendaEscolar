<!-- resources/views/avaliacoes/export/pdf.blade.php -->
<h1>Propostas {{ ucfirst($status) }}</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Chamada Pública</th>
            <th>Região</th>
            <th>Valor Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($propostas as $proposta)
            <tr>
                <td>{{ $proposta->id }}</td>
                <td>{{ $proposta->chamadaPublica->titulo }}</td>
                <td>{{ $proposta->regiao->nome }}</td>
                <td>R$ {{ number_format($proposta->valor_total, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>