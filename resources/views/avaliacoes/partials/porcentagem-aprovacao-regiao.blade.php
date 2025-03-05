<!-- resources/views/avaliacoes/partials/porcentagem-aprovacao-regiao.blade.php -->
<h2 class="mt-5">Porcentagem de Aprovação por Região</h2>
<table class="table">
    <thead>
        <tr>
            <th>Região</th>
            <th>% Aprovada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($porcentagemAprovadaPorRegiao as $regiaoId => $porcentagem)
            <tr>
                <td>{{ $regioes->find($regiaoId)->nome }}</td>
                <td>{{ number_format($porcentagem, 2) }}%</td>
            </tr>
        @endforeach
    </tbody>
</table>