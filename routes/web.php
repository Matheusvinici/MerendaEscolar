<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RegiaoController,
    BairroController,
    PedidoLoteController,
    RecebimentoController,
    AlunoController,
    AvaliacaoController,
    EscolaController,
    AlimentoController,
    CardapioController,
    OrcamentoController,
    PedidoController,
    ChamadaPublicaController,
    ValidacaoController,
    PropostaController,
};

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::resource('regioes', RegiaoController::class);
    Route::resource('bairros', BairroController::class);
   
    Route::resource('avaliacoes', AvaliacaoController::class)->except(['edit', 'update', 'destroy']);
    Route::post('avaliacoes/distribuir', [AvaliacaoController::class, 'distribuir'])->name('avaliacoes.distribuir');
    Route::resource('alimentos', AlimentoController::class);
Route::get('alimentos/quinzena', [AlimentoController::class, 'editDisponibilidade'])
     ->name('alimentos.quinzena');
Route::put('alimentos/quinzena', [AlimentoController::class, 'updateDisponibilidade'])
     ->name('alimentos.quinzena.update');
     Route::patch('/alimentos/{alimento}/toggle-status', [AlimentoController::class, 'toggleStatus'])
    ->name('alimentos.toggle-status');

    // Pedidos Individuais
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    
    Route::prefix('pedidos/lote')->group(function() {
        Route::get('/', [PedidoLoteController::class, 'index'])->name('pedidos.lote.index');
        Route::get('/create', [PedidoLoteController::class, 'create'])->name('pedidos.lote.create');
        Route::post('/', [PedidoLoteController::class, 'store'])->name('pedidos.lote.store');
        Route::get('/pdf/{lote}/{tipo}', [PedidoLoteController::class, 'gerarPdf'])->name('pedidos.lote.pdf');
    });

    Route::prefix('recebimentos')->group(function() {
        Route::get('/', [RecebimentoController::class, 'index'])->name('recebimentos.index');
        Route::get('/pedido/{pedido}', [RecebimentoController::class, 'create'])->name('recebimentos.create');
        Route::post('/pedido/{pedido}', [RecebimentoController::class, 'store'])->name('recebimentos.store');
        Route::get('/{recebimento}', [RecebimentoController::class, 'show'])->name('recebimentos.show');
        Route::get('/anexo/{anexo}/download', [RecebimentoController::class, 'downloadAnexo'])->name('recebimentos.download.anexo');
    });


// Rotas para Alunos
Route::resource('alunos', AlunoController::class);
Route::get('alunos/{aluno}/necessidades', [AlunoController::class, 'calcularNecessidades'])
     ->name('alunos.necessidades');

// Rotas para Alimentos

    Route::resource('escolas', EscolaController::class);
    Route::resource('alimentos', AlimentoController::class);
    Route::post('alimentos/{alimento}/toggle-status', [AlimentoController::class, 'toggleStatus'])
     ->name('alimentos.toggle-status');
     Route::resource('cardapios', CardapioController::class);
     Route::post('cardapios/{cardapio}/toggle-status', [CardapioController::class, 'toggleStatus'])
          ->name('cardapios.toggleStatus');
     Route::post('cardapios/{cardapio}/toggle-padrao', [CardapioController::class, 'togglePadrao'])
          ->name('cardapios.togglePadrao');
     Route::get('cardapios/{cardapio}/generate', [CardapioController::class, 'generatePdf'])
          ->name('cardapios.generate');
     Route::post('cardapios/generate-all', [CardapioController::class, 'generateAllPdfs'])
          ->name('cardapios.generateAll');
    Route::resource('cardapios', CardapioController::class);
    Route::resource('orcamentos', OrcamentoController::class);
    Route::resource('chamadas_publicas', ChamadaPublicaController::class);
    Route::resource('validacoes', ValidacaoController::class);
    Route::get('/avaliacoes/create', [AvaliacaoController::class, 'create'])->name('avaliacoes.create');
    Route::post('/avaliacoes/{propostaId}', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');
    // routes/web.php
Route::get('/avaliacoes/export/pdf', [AvaliacaoController::class, 'exportPdf'])->name('avaliacoes.export.pdf');

   
    Route::resource('propostas', PropostaController::class);
// Rota para exibir o formulário de cadastro de proposta de venda
Route::get('/propostas/create', [PropostaController::class, 'create'])->name('propostas.create');
// Rota para distribuir propostas
Route::post('/avaliacoes/distribuir', [AvaliacaoController::class, 'distribuir'])
     ->name('avaliacoes.distribuir');

// Rota para salvar a proposta de venda
Route::post('/propostas', [PropostaController::class, 'store'])->name('propostas.store');

// Rota para obter alimentos relacionados a uma chamada pública
Route::get('/chamadas-publicas/{id}/alimentos', [PropostaController::class, 'getAlimentosByChamadaPublica']);
    

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
