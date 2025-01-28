<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 2cm;
            padding: 0;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            line-height: 1.3;
            position: relative;
        }
        .header-right {
            position: absolute;
            top: 0;
            right: 0;
            text-align: right;
            font-weight: bold;
            font-size: 11pt;
        }
        .company-info {
            font-size: 11pt;
            line-height: 1.4;
            margin-bottom: 20px;
            max-width: 60%;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin: 30px 0 10px 0;
        }
        .subtitle {
            text-align: center;
            margin: 0 auto;
            max-width: 80%;
            font-size: 11pt;
            line-height: 1.2;
            white-space: normal;
            word-wrap: break-word;
        }
        .sector-info {
            margin: 20px 0;
            line-height: 1.8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 0.5px solid black;
        }
        th, td {
            padding: 6px;
            text-align: left;
            font-size: 11pt;
            vertical-align: middle;
        }
        .header-row th {
            text-align: center;
            height: 40px;
            vertical-align: top;
            padding-top: 4px;
            font-weight: normal;
        }
        .number-row th {
            text-align: center;
            padding: 4px;
            font-weight: normal;
        }
        .data-cell {
            text-align: right !important;
            padding-right: 10px !important;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            font-size: 11pt;
        }
        .dotted-line {
            border-bottom: 1px dotted black;
            display: inline-block;
            width: 200px;
            position: relative;
            top: -3px;
            margin: 0 5px;
        }
        .column-0 { width: 5%; }
        .column-1 { width: 25%; }
        .column-2 { width: 20%; }
        .column-3 { width: 15%; }
        .column-4 { width: 17.5%; }
        .column-5 { width: 17.5%; }
        .empty-row td {
            height: 25px;
        }
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
        cantităților de motorină achiziționată și utilizată aferentă perioadei
        pentru care se solicită acordarea
        ajutorului de stat prin rambursare
    </div>

    <div class="sector-info">
        Sector: vegetal și zootehnic (vegetal / zootehnic / îmbunătățiri funciare, după caz)<br>
        Perioada: trim.{{ str_replace(['T1', 'T2', 'T3'], ['I', 'II', 'III'], substr($perioada, -2)) }} {{ substr($perioada, 0, 4) }}
    </div>

    <table>
        <thead>
            <tr class="header-row">
                <th class="column-0">Nr.<br>crt.</th>
                <th class="column-1">Furnizorul</th>
                <th class="column-2">Nr.<br>facturii/bonului<br>fiscal</th>
                <th class="column-3">Data<br>facturii/bonului<br>fiscal</th>
                <th class="column-4">Cantitatea de<br>motorină<br>facturată<br>(litri)</th>
                <th class="column-5">Cantitatea de<br>motorină<br>utilizată<br>(litri)</th>
            </tr>
            <tr class="number-row">
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
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td>{{ $bon->rezultatOcr->furnizor }}</td>
                    <td style="text-align: center">{{ $bon->rezultatOcr->numar_bon }}</td>
                    <td style="text-align: center">{{ \Carbon\Carbon::parse($bon->rezultatOcr->data_bon)->format('d.m.Y') }}</td>
                    <td class="data-cell">{{ number_format($bon->rezultatOcr->cantitate_facturata, 2) }}</td>
                    <td class="data-cell">{{ number_format($bon->rezultatOcr->cantitate_utilizata, 2) }}</td>
                </tr>
            @endforeach
            
            @for($i = count($bonuri) + 1; $i <= 15; $i++)
                <tr class="empty-row">
                    <td style="text-align: center">{{ $i }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor

            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold; padding-right: 10px">TOTAL:</td>
                <td class="data-cell" style="font-weight: bold">{{ number_format($totals['cantitate_facturata'], 2) }}</td>
                <td class="data-cell" style="font-weight: bold">{{ number_format($totals['cantitate_utilizata'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div style="margin-bottom: 20px">
            Data<span class="dotted-line"></span>
        </div>
        <div style="margin-bottom: 10px">
            Numele și prenumele {{ $metadata['nume_prenume'] ?? 'MIHALCA VASILE' }}
        </div>
        <div style="margin-bottom: 10px">
            Funcția {{ $metadata['functie'] ?? 'administrator' }} (administrator, reprezentant legal, după caz)<span class="dotted-line"></span>
        </div>
        <div>
            Semnătura și ștampila, după caz<span class="dotted-line"></span>
        </div>
    </div>
</body>
</html>