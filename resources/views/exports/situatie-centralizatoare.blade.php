<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 2.5cm 2cm;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            line-height: 1.3;
        }
        .header-right {
            position: absolute;
            top: 0;
            right: 0;
            text-align: right;
            font-size: 10pt;
        }
        .company-info {
            margin-bottom: 20px;
            font-size: 10pt;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin: 20px 0 10px 0;
            font-size: 12pt;
        }
        .subtitle {
            text-align: center;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .sector-info {
            margin-bottom: 15px;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font-size: 10pt;
        }
        th {
            background-color: white;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            font-size: 10pt;
        }
        .signature-line {
            margin-top: 5px;
            border-bottom: 1px solid black;
        }
        .column-0 { width: 5%; }
        .column-1 { width: 25%; }
        .column-2 { width: 25%; }
        .column-3 { width: 15%; }
        .column-4 { width: 15%; }
        .column-5 { width: 15%; }
    </style>
</head>
<body>
    <div class="header-right">
        Anexa nr.8<br>
        la Procedurile specifice
    </div>

    <div class="company-info">
        {{ $metadata['nume_companie'] ?? 'MIHALCA I. VASILE II' }}<br>
        CUI/CNP {{ $metadata['cui_cnp'] ?? '34395231' }}<br>
        ID APIA {{ $metadata['id_apia'] ?? 'RO008688644' }}<br>
        Sediul/Domiciliul<br>
        Localitatea {{ $metadata['localitate'] ?? 'PETROVA' }}<br>
        Județul {{ $metadata['judet'] ?? 'MARAMUREȘ' }}
    </div>

    <div class="title">SITUAȚIA CENTRALIZATOARE</div>
    <div class="subtitle">
        cantităților de motorină achiziționată și utilizată aferentă perioadei pentru care se solicită acordarea<br>
        ajutorului de stat prin rambursare
    </div>

    <div class="sector-info">
        Sector: vegetal și zootehnic (vegetal / zootehnic / îmbunătățiri funciare, după caz)<br>
       <strong>Perioada:</strong> trim.{{ str_replace(['T1', 'T2', 'T3'], ['I', 'II', 'III'], substr($perioada, -2)) }} {{ substr($perioada, 0, 4) }}<br>
    </div>

    <table>
        <thead>
            <tr>
                <th class="column-0">Nr.<br>crt.</th>
                <th class="column-1">Furnizorul</th>
                <th class="column-2">Nr. facturii/bonului fiscal</th>
                <th class="column-3">Data facturii/bonului fiscal</th>
                <th class="column-4">Cantitatea de motorină facturată (litri)</th>
                <th class="column-5">Cantitatea de motorină utilizată (litri)</th>
            </tr>
            <tr>
                <th>0</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bonuri as $index => $bon)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bon->rezultatOcr->furnizor }}</td>
                    <td>{{ $bon->rezultatOcr->numar_bon }}</td>
                    <td>{{ \Carbon\Carbon::parse($bon->rezultatOcr->data_bon)->format('d.m.Y') }}</td>
                    <td style="text-align: right">{{ number_format($bon->rezultatOcr->cantitate_facturata, 2) }}</td>
                    <td style="text-align: right">{{ number_format($bon->rezultatOcr->cantitate_utilizata, 2) }}</td>
                </tr>
            @endforeach
            @for($i = count($bonuri) + 1; $i <= 15; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL:</td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($totals['cantitate_facturata'], 2) }}</td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($totals['cantitate_utilizata'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>
            Data ................................................
        </div>
        <div style="margin-top: 10px;">
            Numele și prenumele {{ $metadata['nume_prenume'] ?? 'MIHALCA VASILE' }}<br>
            Funcția administrator (administrator, reprezentant legal, după caz) ...............................<br>
            Semnătura și ștampila, după caz ................................
        </div>
    </div>
</body>
</html>