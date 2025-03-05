<!-- resources/views/avaliacoes/partials/resumo-alimentos.blade.php -->
<h2 class="mt-5">Resumo de Alimentos</h2>
<table class="table">
    <thead>
        <tr>
            <th>Alimento</th>
            <th>Total Ofertado (kg)</th>
            <th>Limite da Chamada (kg)</th>
            <th>Disponível (kg)</th>
            <th>Total Aprovado (kg)</th>
            <th>% Aprovado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alimentosTotais as $alimentoId => $alimento)
            <tr>
                <td>{{ $alimento['nome'] }}</td>
                <td>{{ $alimento['total_kg'] }}</td>
                <td>{{ $alimento['limite_chamada'] }}</td>
                <td>{{ $alimento['limite_chamada'] - $alimento['total_kg'] }}</td>
                <td>{{ $alimento['total_aprovado'] }}</td>
                <td>
                    @if ($alimento['total_kg'] > 0)
                        {{ number_format(($alimento['total_aprovado'] / $alimento['total_kg']) * 100, 2) }}%
                    @else
                        0%
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>