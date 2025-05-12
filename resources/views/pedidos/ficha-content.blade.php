<div class="info">
    <p><strong>Escola:</strong> {{ $pedido->escola->nome }}</p>
    <p><strong>Período:</strong> {{ $pedido->data_inicio->format('d/m/Y') }} a {{ $pedido->data_fim->format('d/m/Y') }}</p>
    @php
        $aluno = $pedido->escola->alunos->first();
        $totalAlunos = ($aluno->creche_parcial + $aluno->creche_integral + 
                       $aluno->pre_parcial + $aluno->pre_integral + 
                       $aluno->fundamental_parcial + $aluno->fundamental_integral + 
                       $aluno->eja);
    @endphp
    <p><strong>Nº de Alunos:</strong> {{ $totalAlunos }}</p>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ITEM</th>
            <th>UNIDADE</th>
            <th>QUANTIDADE</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedido->itens as $item)
        <tr>
            <td>{{ $item->alimento->nome }}</td>
            <td>{{ $item->unidade_medida }}</td>
            <td>{{ number_format($item->quantidade, 2) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2"><strong>TOTAL</strong></td>
            <td><strong>{{ number_format($pedido->itens->sum('quantidade'), 2) }}</strong></td>
        </tr>
    </tbody>
</table>

<div class="signature">
    <div>
        <p>CPF:</p>
        <div class="signature-line"></div>
        <p>Assinatura do Responsável</p>
    </div>
    <div>
        <p>DATA: ____/____/______</p>
        <div class="signature-line"></div>
        <p>Assinatura do Recebedor</p>
    </div>
</div>

<div class="footer">
    <p>Obs.: Obrigatório a assinatura e data</p>
</div>