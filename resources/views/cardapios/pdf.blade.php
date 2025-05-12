<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cardápio - {{ $cardapio->escola->nome }} - {{ $cardapio->segmento->nome }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { 
            display: flex; 
            align-items: center; 
            margin-bottom: 20px;
            border-bottom: 2px solid #1e88e5;
            padding-bottom: 10px;
        }
        .logo { 
            height: 80px; 
            margin-right: 20px;
        }
        .title {
            color: #1e88e5;
            margin: 0;
        }
        .subtitle {
            color: #555;
            margin: 5px 0 0 0;
            font-size: 16px;
        }
        .periodo {
            background-color: #1e88e5;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #1e88e5;
            color: white;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f5f9ff;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ storage_path('app/public/logoprefeitura.png') }}" class="logo">
        <div>
            <h1 class="title">Cardápio Escolar</h1>
            <p class="subtitle">
                {{ $cardapio->escola->nome }} - {{ $cardapio->segmento->nome }}
            </p>
        </div>
    </div>

    <div class="periodo">
        Período: {{ \Carbon\Carbon::parse($cardapio->data_inicio)->format('d/m/Y') }} 
        a {{ \Carbon\Carbon::parse($cardapio->data_fim)->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Dia</th>
                <th>Café da Manhã</th>
                <th>Lanche</th>
                <th>Almoço</th>
                <th>Lanche da Tarde</th>
                <th>Jantar</th>
            </tr>
        </thead>
        <tbody>
            @php
                $startDate = \Carbon\Carbon::parse($cardapio->data_inicio);
                $endDate = \Carbon\Carbon::parse($cardapio->data_fim);
                $days = $startDate->diffInDays($endDate) + 1;
            @endphp
            
            @for($i = 0; $i < $days; $i++)
            <tr>
                <td>{{ $startDate->copy()->addDays($i)->format('d/m/Y') }}<br>({{ $startDate->copy()->addDays($i)->translatedFormat('l') }})</td>
                <td>
                    @foreach($cardapio->alimentos->where('categoria', 'cafe_manha') as $alimento)
                        • {{ $alimento->nome }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($cardapio->alimentos->where('categoria', 'lanche') as $alimento)
                        • {{ $alimento->nome }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($cardapio->alimentos->where('categoria', 'almoco') as $alimento)
                        • {{ $alimento->nome }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($cardapio->alimentos->where('categoria', 'lanche_tarde') as $alimento)
                        • {{ $alimento->nome }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($cardapio->alimentos->where('categoria', 'jantar') as $alimento)
                        • {{ $alimento->nome }}<br>
                    @endforeach
                </td>
            </tr>
            @endfor
        </tbody>
    </table>

    @if($cardapio->observacoes)
    <div class="observacoes">
        <h3 style="color: #1e88e5;">Observações:</h3>
        <p>{{ $cardapio->observacoes }}</p>
    </div>
    @endif

    <div class="footer">
        Gerado em {{ now()->format('d/m/Y H:i') }} | Secretaria Municipal de Educação
    </div>
</body>
</html>