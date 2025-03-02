<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validacao;
use Illuminate\Support\Facades\Storage;

class ValidacaoController extends Controller
{
    public function index()
    {
        $validacoes = Validacao::all();
        return view('validacoes.index', compact('validacoes'));
    }

    public function create()
    {
        return view('validacoes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'DAP_juridico' => 'nullable|file|mimes:pdf,jpg,png',
            'alvara' => 'nullable|file|mimes:pdf,jpg,png',
            'alvara_sanitario' => 'nullable|file|mimes:pdf,jpg,png',
            'certidao_negativa_deb_municipio' => 'nullable|file|mimes:pdf,jpg,png',
            'certidao_negativa_deb_estaduais' => 'nullable|file|mimes:pdf,jpg,png',
            'certidao_concordata_falencia_recuperacao' => 'nullable|file|mimes:pdf,jpg,png',
            'certidao_deb_credito_tribt_federal' => 'nullable|file|mimes:pdf,jpg,png',
            'certidao_negativa_trabalhista' => 'nullable|file|mimes:pdf,jpg,png',
            'fgts' => 'nullable|file|mimes:pdf,jpg,png',
            'copia_estatuto_posse' => 'nullable|file|mimes:pdf,jpg,png',
            'comprovante_end_cooperativa' => 'nullable|file|mimes:pdf,jpg,png',
            'rg_cpf_representantes_legais' => 'nullable|file|mimes:pdf,jpg,png',
            'comprovante_resd_representantes_legais' => 'nullable|file|mimes:pdf,jpg,png',
            'decl_representante_controle_atendimento' => 'nullable|file|mimes:pdf,jpg,png',
            'projeto_venda' => 'nullable|file|mimes:pdf,jpg,png',
            'declaracao_gen_alimenticio_producao' => 'nullable|file|mimes:pdf,jpg,png',
            'cert_prod_organica' => 'nullable|file|mimes:pdf,jpg,png',
            'cert_prod_agroecologica' => 'nullable|file|mimes:pdf,jpg,png',
            'regs_sanitario_alimentos' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        $validacao = new Validacao();
        foreach ($validatedData as $key => $file) {
            if ($file) {
                $validacao->$key = $file->store('validacoes', 'public');
            }
        }
        $validacao->save();

        return redirect()->route('validacoes.index')->with('success', 'Documentos enviados com sucesso!');
    }
    
    public function show($id)
    {
        $validacao = Validacao::findOrFail($id);
    
        return view('validacoes.show', compact('validacao'));
    }
    

}