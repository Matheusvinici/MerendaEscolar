<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AlimentoController,
    CardapioController,
    OrcamentoController,
    EscolaController,
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

    Route::resource('alimentos', AlimentoController::class);
    Route::resource('cardapios', CardapioController::class);
    Route::resource('orcamentos', OrcamentoController::class);
    Route::resource('escolas', EscolaController::class);
    Route::resource('chamadas_publicas', ChamadaPublicaController::class);
    Route::resource('validacoes', ValidacaoController::class);
   
    Route::resource('propostas', PropostaController::class);
// Rota para exibir o formulário de cadastro de proposta de venda
Route::get('/propostas/create', [PropostaController::class, 'create'])->name('propostas.create');

// Rota para salvar a proposta de venda
Route::post('/propostas', [PropostaController::class, 'store'])->name('propostas.store');

// Rota para obter alimentos relacionados a uma chamada pública
Route::get('/chamadas-publicas/{id}/alimentos', [PropostaController::class, 'getAlimentosByChamadaPublica']);
    

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
