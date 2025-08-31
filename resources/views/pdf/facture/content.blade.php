@php
    $primary = [
        '50' => '#fff3f1',
        '100' => '#ffe4df',
        '200' => '#ffcdc5',
        '300' => '#ffab9d',
        '400' => '#ff7b65',
        '500' => '#ff5134',
        '600' => '#e53012',
        '700' => '#c7280e',
        '800' => '#a5240f',
        '900' => '#882414',
        '950' => '#4a0f05',
    ];
    $warning = [
        '50' => '#fefce8',
        '100' => '#fef9c3',
        '200' => '#fef08a',
        '300' => '#fde047',
        '400' => '#facc15',
        '500' => '#eab308',
        '600' => '#ca8a04',
        '700' => '#a16207',
        '800' => '#854d0e',
        '900' => '#713f12',
        '950' => '#422006',
    ];
    $info = [
        '50' => '#eff6ff',
        '100' => '#dbeafe',
        '200' => '#bfdbfe',
        '300' => '#93c5fd',
        '400' => '#60a5fa',
        '500' => '#3b82f6',
        '600' => '#2563eb',
        '700' => '#1d4ed8',
        '800' => '#1e40af',
        '900' => '#1e3a8a',
        '950' => '#172554',
    ];
    $success = [
        '50' => '#f0fdf4',
        '100' => '#dcfce7',
        '200' => '#bbf7d0',
        '300' => '#86efac',
        '400' => '#4ade80',
        '500' => '#22c55e',
        '600' => '#16a34a',
        '700' => '#15803d',
        '800' => '#166534',
        '900' => '#14532d',
        '950' => '#052e16',
    ];
    $gray = [
        '50' => '#f8fafc',
        '100' => '#f1f5f9',
        '200' => '#e2e8f0',
        '300' => '#cbd5e1',
        '400' => '#94a3b8',
        '500' => '#64748b',
        '600' => '#475569',
        '700' => '#334155',
        '800' => '#1e293b',
        '900' => '#0f172a',
        '950' => '#020617',
    ];
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF</title>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        h1, h2, h3, h4, h5, h6, p {
            margin: 0;
        }

        html {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Bricolage Grotesque", sans-serif;
            font-size: 11pt;
            color: {{ $gray['700'] }};
        }
    </style>
</head>
<body>
<table style="width: 100%; table-layout: fixed;">
    <tr>
        <td></td>
        <td style="vertical-align: top; padding-left: 5mm;">
            <p style="font-weight: 700; margin-bottom: 2mm;">{{ $client_designation  }}</p>
            <p>{{ $client_address_line_1 }}</p>
            @if ($client_address_line_2)
                <p>{{ $client_address_line_2 }}</p>
            @endif
            @if ($client_address_line_3)
                <p>{{ $client_address_line_3 }}</p>
            @endif
            <p>{{ $client_address_zipcode_city }}</p>
        </td>
    </tr>
</table>

<table style="width: 100%; margin-top: 10mm; margin-bottom: 10mm; table-layout: fixed; border-collapse: collapse;">
    <thead>
    <tr style="background-color: {{ $gray['100'] }}; vertical-align: middle;">
        <th style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: left; width: 100%;">Désignation
        </th>
        <th style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: center; width: 15mm;">Qté</th>
        <th style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: right; width: 32mm;">P.U. H.T.
        </th>
        <th style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: right; width: 32mm;">Total H.T.
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($lines as $line)
        <tr style="vertical-align: top;">
            <td style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: left;">
                <p style="font-weight: 500;">{{ $line['designation']  }}</p>
                @if ($line['description'])
                    <p style="margin-top: 1mm; font-size: 10pt; text-wrap: balance;">{{ $line['description'] }}</p>
                @endif
            </td>
            <td style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: center; font-variant-numeric: tabular-nums slashed-zero;">{{ $line['quantity'] }}</td>
            <td style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: right; font-variant-numeric: tabular-nums slashed-zero;">@money($line['amount'])</td>
            <td style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: right; font-weight: 700; font-variant-numeric: tabular-nums slashed-zero;">@money($line['total_amount'])</td>
        </tr>
    @endforeach

    <tr style="vertical-align: middle;">
        <td></td>
        <td colspan="2"
            style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: left; text-transform: uppercase;">
            Total H.T.
        </td>
        <td style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; font-weight: 700; text-align: right; font-variant-numeric: tabular-nums slashed-zero;">@money($totals['ht'])</td>
    </tr>
    <tr style="vertical-align: middle;">
        <td></td>
        <td colspan="2"
            style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; text-align: left; text-transform: uppercase;">
            Total T.T.C.
        </td>
        <td style="padding: 2mm 3mm; border: 2pt solid {{ $gray['600'] }}; font-weight: 700; text-align: right; font-variant-numeric: tabular-nums slashed-zero;">@money($totals['ttc'])</td>
    </tr>

    </tbody>
</table>

<table
    style="table-layout: fixed; width: 100%; font-size: 10pt; border-collapse: collapse; margin-top: 10mm; margin-bottom: 10mm;">
    <tr style="vertical-align: middle;">
        <td colspan="2"
            style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
            Méthodes de paiement acceptées
        </td>
    </tr>

    <tr style="vertical-align: top;">
        <td style="padding: 3mm; border: 1pt dashed {{ $gray['500'] }};">
            <p style="margin-bottom: 2mm; font-weight: 600;">Paiement par carte bancaire</p>
            <p style="text-wrap: pretty;">
                RDV sur <a target="_blank"
                           href="https://www.helloasso.com/associations/tennis-de-table-castelnovien/paiements/paiement-flexible"
                           style="text-decoration: none; color: {{ $primary['600'] }}; font-weight: 500;">go.ttcastelnovien.com/helloasso</a>.
                Saisissez le montant à régler puis suivez la procédure indiquée.
                La plateforme rajoute un pourcentage au montant renseigné que vous pouvez retirer si vous le souhaitez.
            </p>
        </td>

        <td style="padding: 3mm; border: 1pt dashed {{ $gray['500'] }};">
            <p style="margin-bottom: 2mm; font-weight: 600;">Paiement par PayPal</p>
            <p style="text-wrap: pretty;">
                RDV sur <a target="_blank"
                           href="https://paypal.me/ttcastelnovien16/{{ str(money($totals['ttc']))->substr(0, -2) }}"
                           style="text-decoration: none; color: {{ $primary['600'] }}; font-weight: 500;">paypal.me/ttcastelnovien16/{{ str(money($totals['ttc']))->substr(0, -2) }}</a>
                puis suivre la procédure indiquée.
                Attention, bien sélectionner l’option <span style="color: {{ $info['500'] }}">« Envoi d’argent à un proche »</span>
                pour
                ne pas avoir de commission,
                et renseigner le numéro de facture dans l’objet du paiement.
            </p>
        </td>
    </tr>

    <tr style="vertical-align: top;">
        <td style="padding: 3mm; border: 1pt dashed {{ $gray['500'] }};">
            <p style="margin-bottom: 2mm; font-weight: 600;">Paiement par virement bancaire</p>
            <table style="width: 100%; table-layout: fixed; border-collapse: collapse;">
                <tr>
                    <td style="line-height: 1; padding: 2mm 2mm 1.5mm; border: 1pt solid {{ $gray['400'] }}; width: 20mm; font-weight: 700;">
                        IBAN
                    </td>
                    <td style="line-height: 1; padding: 2mm 2mm 1.5mm; border: 1pt solid {{ $gray['400'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                        FR76 1240 6001 2580 0257 9207 081
                    </td>
                </tr>
                <tr>
                    <td style="line-height: 1; padding: 2mm 2mm 1.5mm; border: 1pt solid {{ $gray['400'] }}; width: 20mm; font-weight: 700;">
                        BIC
                    </td>
                    <td style="line-height: 1; padding: 2mm 2mm 1.5mm; border: 1pt solid {{ $gray['400'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                        AGRIFRPP824
                    </td>
                </tr>
                <tr>
                    <td style="line-height: 1; padding: 2mm 2mm 1.5mm; border: 1pt solid {{ $gray['400'] }}; width: 20mm; font-weight: 700;">
                        Banque
                    </td>
                    <td style="line-height: 1; padding: 2mm 2mm 1.5mm; border: 1pt solid {{ $gray['400'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                        Crédit Agricole Charente-Périgord
                    </td>
                </tr>
            </table>
        </td>

        <td style="padding: 3mm; border: 1pt dashed {{ $gray['500'] }};">
            <p style="margin-bottom: 2mm; font-weight: 600;">Paiement par chèque</p>
            <p style="text-wrap: pretty;">
                Mettre le chèque à l’ordre de <span
                    style="color: {{ $info['500'] }}">Tennis de Table Castelnovien</span> et l’apporter lors des
                créneaux d’entraînement.
            </p>
        </td>
    </tr>
</table>
</body>
</html>
