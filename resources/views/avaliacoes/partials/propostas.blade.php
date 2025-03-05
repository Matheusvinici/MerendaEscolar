<!-- resources/views/avaliacoes/partials/propostas.blade.php -->

<h2 class="mt-5">Propostas {{ ucfirst($status) }}</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Chamada Pública</th>
            <th>Região</th>
            <th>Valor Total</th>
            <th>Quantidade Ofertada</th>
            <th>Quantidade Aprovada</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($propostas as $proposta)
            <tr>
                <td>{{ $proposta->id }}</td>
                <td>{{ $proposta->chamadaPublica->descricao }}</td>
                <td>{{ $proposta->regiao->nome }}</td>
                @foreach ($proposta->alimentos as $alimento)
                            <td>R$ {{ number_format($alimento->pivot->valor_total, 2, ',', '.') }}</td>
                        @endforeach
                <td>
                    @foreach ($proposta->alimentos as $alimento)
                        {{ $alimento->pivot->quantidade_ofertada }} Kg/Litro<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($proposta->alimentos as $alimento)
                        {{ $alimento->pivot->quantidade_aprovada ?? '0' }} Kg/Litro<br>
                    @endforeach
                </td>
                <td>{{ $proposta->status }}</td>
                <td>
                    <a href="{{ route('propostas.show', $proposta->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                    @if ($status === 'pendente')
                        <a href="{{ route('avaliacoes.create', ['proposta' => $proposta->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-check"></i> Avaliar
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- resources/views/avaliacoes/partials/propostas.blade.php -->
{{ $propostas->appends(['tab' => $status])->links() }}