<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fichas de Entrega - Lote {{ $pedidos->first()->lote_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .page {
            page-break-after: always;
            padding: 20px;
        }
        .ficha {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .header img.logo {
            position: absolute;
            left: 0;
            top: 0;
            height: 50px;
        }
        .header div {
            margin-left: 60px;
        }
        .title {
            font-size: 14px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 12px;
            margin: 2px 0;
        }
        .info p {
            margin: 3px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .signature {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 180px;
            margin-top: 30px;
        }
        .footer {
            font-size: 9px;
            text-align: center;
            margin-top: 10px;
        }
        .via {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

@foreach($pedidos as $pedido)
    <div class="page">
        @php
            $aluno = $pedido->escola->alunos->first();
            $totalAlunos = $aluno ? (
                $aluno->creche_parcial + $aluno->creche_integral +
                $aluno->pre_parcial + $aluno->pre_integral +
                $aluno->fundamental_parcial + $aluno->fundamental_integral +
                $aluno->eja
            ) : 0;
        @endphp

        @for ($i = 1; $i <= 3; $i++)
        <div class="ficha">
            <div class="via">{{ $i }}ª VIA - {{ ['ESCOLA', 'NÚCLEO', 'FORNECEDOR'][$i-1] }}</div>
            <div class="header">
                <img src="{{ public_path('images/logoprefeitura.png') }}" class="logo">
                <div>
                    <h2 class="title">PREFEITURA MUNICIPAL DE JUAZEIRO - BA</h2>
                    <h3 class="subtitle">SECRETARIA DE EDUCAÇÃO</h3>
                    <h3 class="subtitle">NÚCLEO DE ALIMENTAÇÃO ESCOLAR</h3>
                </div>
            </div>

            <div class="info">
                <p><strong>Escola:</strong> {{ $pedido->escola->nome }}</p>
                <p><strong>Período:</strong> {{ $pedido->data_inicio->format('d/m/Y') }} a {{ $pedido->data_fim->format('d/m/Y') }}</p>
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
                            <td>{{ round($item->quantidade) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><strong>TOTAL</strong></td>
                        <td><strong>{{ round($pedido->itens->sum('quantidade')) }}</strong></td>
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
        </div>
        @endfor
    </div>
@endforeach

</body>
</html>
