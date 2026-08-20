<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Export' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 15px;
            line-height: 1.4;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-size: 16px;
            border-bottom: 2px solid #0065FF;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            max-width: 120px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .header-info {
            margin-bottom: 15px;
            text-align: right;
            font-size: 8px;
            color: #666;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }

        .summary {
            background-color: #e7f3ff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header-info">
        Oluşturulma Tarihi: {{ now()->format('d.m.Y H:i:s') }}
    </div>

    <h1>{{ $title ?? 'Veri Dışa Aktarma' }}</h1>

    @if(isset($records) && $records->count() > 0)
        <div class="summary">
            <strong>Özet:</strong> Toplam {{ $records->count() }} kayıt listeleniyor.
        </div>

        <table>
            <thead>
                <tr>
                    @foreach($columns as $column)
                        <th>{{ $columnMappings[$column] ?? ucfirst(str_replace('_', ' ', $column)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        @foreach($columns as $column)
                            <td>
                                @php
                                    $value = $record->$column;
                                    if (is_null($value)) {
                                        echo '-';
                                    } elseif (is_bool($value)) {
                                        echo $value ? 'Evet' : 'Hayır';
                                    } elseif ($value instanceof \Carbon\Carbon) {
                                        echo $value->format('d.m.Y H:i');
                                    } else {
                                        echo htmlspecialchars($value);
                                    }
                                @endphp
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 50px; color: #666;">
            Dışa aktarılacak kayıt bulunamadı.
        </div>
    @endif

    <div class="footer">
        Bu rapor sistem tarafından otomatik olarak oluşturulmuştur.
        @if(isset($records))
            | Toplam {{ $records->count() }} kayıt
        @endif
    </div>
</body>
</html>
