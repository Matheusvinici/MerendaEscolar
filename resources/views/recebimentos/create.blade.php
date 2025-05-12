@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Recebimento - {{ $pedido->escola->nome }}</h1>
    <p>Pedido #{{ $pedido->id }} - Período: {{ $pedido->data_inicio->format('d/m/Y') }} a {{ $pedido->data_fim->format('d/m/Y') }}</p>
    
    <form method="POST" action="{{ route('recebimentos.store', $pedido->id) }}" enctype="multipart/form-data">
        @csrf
        
        <div class="card mb-4">
            <div class="card-header">Informações do Recebimento</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_recebimento">Data/Hora do Recebimento</label>
                            <input type="datetime-local" class="form-control" id="data_recebimento" name="data_recebimento" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="atraso_minutos">Atraso (minutos)</label>
                            <input type="number" class="form-control" id="atraso_minutos" name="atraso_minutos">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Itens Recebidos</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Quantidade Prevista</th>
                            <th>Quantidade Recebida</th>
                            <th>Diferença</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->itens as $item)
                        <tr>
                            <td>{{ $item->alimento->nome }} ({{ $item->unidade_medida }})</td>
                            <td>{{ number_format($item->quantidade, 3, ',', '.') }}</td>
                            <td>
                                <input type="number" step="0.001" class="form-control" 
                                    name="itens[{{ $item->id }}][quantidade_recebida]" 
                                    value="{{ $item->quantidade }}" required>
                            </td>
                            <td class="diferenca">0</td>
                            <td>
                                <input type="text" class="form-control" 
                                    name="itens[{{ $item->id }}][observacoes]">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Qualidade dos Alimentos</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="qualidade_avaliacao">Avaliação da Qualidade (1-5)</label>
                    <select class="form-control" id="qualidade_avaliacao" name="qualidade_avaliacao">
                        <option value="">Selecione...</option>
                        <option value="1">1 - Péssima</option>
                        <option value="2">2 - Ruim</option>
                        <option value="3">3 - Regular</option>
                        <option value="4">4 - Boa</option>
                        <option value="5">5 - Excelente</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="qualidade_observacoes">Observações sobre a Qualidade</label>
                    <textarea class="form-control" id="qualidade_observacoes" name="qualidade_observacoes" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="anexos">Anexar Fotos/Relatórios (JPEG, PNG, PDF)</label>
                    <input type="file" class="form-control-file" id="anexos" name="anexos[]" multiple>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="observacoes">Observações Gerais</label>
            <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Recebimento</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    // Calcula diferença automaticamente
    document.querySelectorAll('input[name^="itens"]').forEach(input => {
        if (input.name.includes('quantidade_recebida')) {
            input.addEventListener('change', function() {
                const row = this.closest('tr');
                const prevista = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('.', '').replace(',', '.'));
                const recebida = parseFloat(this.value);
                const diferenca = recebida - prevista;
                
                row.querySelector('.diferenca').textContent = diferenca.toFixed(3).replace('.', ',');
                
                // Destaca se houver diferença
                if (diferenca !== 0) {
                    row.querySelector('.diferenca').classList.add(diferenca > 0 ? 'text-success' : 'text-danger');
                    row.querySelector('.diferenca').classList.remove(diferenca > 0 ? 'text-danger' : 'text-success');
                } else {
                    row.querySelector('.diferenca').classList.remove('text-success', 'text-danger');
                }
            });
        }
    });
</script>
@endsection