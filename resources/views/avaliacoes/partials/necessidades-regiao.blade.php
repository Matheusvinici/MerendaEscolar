<!-- resources/views/avaliacoes/partials/necessidades-regiao.blade.php -->
<h2 class="mt-5">Região: {{ $dados['regiao'] }}</h2>
<table class="table">
    <thead>
        <tr>
            <th>Alimento</th>
            <th>Necessário (kg/litro)</th>
            <th>Ofertado (kg/litro)</th>
            <th>Diferença (kg/litro)</th>
            <th>Total Aprovado (kg/litro)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dados['necessidades'] as $alimentoId => $alimento)
            <tr>
                <td>{{ $alimento['nome'] }}</td>
                <td>{{ $alimento['total_necessario'] }}</td>
                <td>{{ $alimento['total_ofertado'] }}</td>
                <td>{{ $alimento['total_necessario'] - $alimento['total_ofertado'] }}</td>
                <td>{{ $alimento['total_aprovado'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>