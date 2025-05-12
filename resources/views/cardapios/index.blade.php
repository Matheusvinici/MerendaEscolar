@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">Gerenciamento de Cardápios</h2>
            <p class="text-muted">Cadastre e gere cardápios para diferentes segmentos</p>
        </div>
        <a href="{{ route('cardapios.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus me-2"></i>Novo Cardápio
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">Gerar Cardápios em PDF</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cardapios.generateAll') }}" method="POST" target="_blank">
                @csrf
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="escola_id" class="form-label">Escola</label>
                        <select class="form-select" id="escola_id" name="escola_id" required>
                            <option value="">Selecione a escola...</option>
                            @foreach($escolas as $escola)
                                <option value="{{ $escola->id }}">{{ $escola->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="segmento_id" class="form-label">Segmento</label>
                        <select class="form-select" id="segmento_id" name="segmento_id" required>
                            <option value="">Selecione o segmento...</option>
                            @foreach($segmentos as $segmento)
                                <option value="{{ $segmento->id }}">{{ $segmento->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-file-pdf me-2"></i>Gerar PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="ps-4">Nome</th>
                        <th>Escola</th>
                        <th>Segmento</th>
                        <th>Período</th>
                        <th class="text-center">Ativo</th>
                        <th class="text-center">Padrão</th>
                        <th>Alimentos</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cardapios as $cardapio)
                    <tr class="border-top">
                        <td class="ps-4 fw-medium">{{ $cardapio->nome }}</td>
                        <td>{{ $cardapio->escola->nome }}</td>
                        <td>{{ $cardapio->segmento->nome }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($cardapio->data_inicio)->format('d/m/Y') }} - 
                            {{ \Carbon\Carbon::parse($cardapio->data_fim)->format('d/m/Y') }}
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input toggle-status" type="checkbox" 
                                       data-id="{{ $cardapio->id }}" {{ $cardapio->ativo ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input toggle-padrao" type="checkbox" 
                                       data-id="{{ $cardapio->id }}" {{ $cardapio->padrao ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            @foreach($cardapio->alimentos->take(3) as $alimento)
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $alimento->nome }}</span>
                            @endforeach
                            @if($cardapio->alimentos->count() > 3)
                                <span class="badge bg-secondary">+{{ $cardapio->alimentos->count() - 3 }}</span>
                            @endif
                        </td>
                        <td class="pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('cardapios.generate', $cardapio->id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-circle" 
                                   title="Gerar PDF" data-bs-toggle="tooltip">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('cardapios.show', $cardapio->id) }}" 
                                   class="btn btn-sm btn-outline-info rounded-circle" 
                                   title="Visualizar" data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cardapios.edit', $cardapio->id) }}" 
                                   class="btn btn-sm btn-outline-warning rounded-circle" 
                                   title="Editar" data-bs-toggle="tooltip">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('cardapios.destroy', $cardapio->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" 
                                            title="Excluir" data-bs-toggle="tooltip" 
                                            onclick="return confirm('Tem certeza que deseja excluir este cardápio?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-database me-2"></i>Nenhum cardápio cadastrado
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ativar tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Toggle status ativo
        document.querySelectorAll('.toggle-status').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const cardapioId = this.dataset.id;
                fetch(`/cardapios/${cardapioId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        const toastBody = document.querySelector('.toast-body');
                        toastBody.textContent = `Cardápio ${data.ativo ? 'ativado' : 'desativado'} com sucesso!`;
                        toast.show();
                    }
                });
            });
        });

        // Toggle padrão
        document.querySelectorAll('.toggle-padrao').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const cardapioId = this.dataset.id;
                fetch(`/cardapios/${cardapioId}/toggle-padrao`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        const toastBody = document.querySelector('.toast-body');
                        toastBody.textContent = `Cardápio ${data.padrao ? 'definido como padrão' : 'removido como padrão'}!`;
                        toast.show();
                        
                        // Se foi marcado como padrão, desmarca outros checkboxes
                        if (data.padrao) {
                            document.querySelectorAll('.toggle-padrao').forEach(cb => {
                                if (cb.dataset.id !== cardapioId) {
                                    cb.checked = false;
                                }
                            });
                        }
                    }
                });
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.5em;
    }
    .badge {
        font-weight: 500;
        margin-right: 4px;
    }
</style>
@endpush