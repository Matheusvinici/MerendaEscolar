<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AlimentoController,
    CardapioController,
    OrcamentoController,
    OrcamentoAlimentoController,
    EscolaController,
    FaixaEtariaController,
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
    Route::resource('etarias', FaixaEtariaController::class);


    Route::prefix('orcamentos/{orcamento}/alimentos')->group(function () {
        Route::get('create', [OrcamentoAlimentoController::class, 'create'])->name('orcamentos.alimentos.create');
        Route::post('store', [OrcamentoAlimentoController::class, 'store'])->name('orcamentos.alimentos.store');
        Route::get('{alimento}/edit', [OrcamentoAlimentoController::class, 'edit'])->name('orcamentos.alimentos.edit');
        Route::put('{alimento}/update', [OrcamentoAlimentoController::class, 'update'])->name('orcamentos.alimentos.update');
        Route::delete('{alimento}/destroy', [OrcamentoAlimentoController::class, 'destroy'])->name('orcamentos.alimentos.destroy');
    });

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
