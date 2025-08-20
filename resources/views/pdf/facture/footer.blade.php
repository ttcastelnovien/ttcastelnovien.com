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

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title></title>
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
        }
    </style>
</head>
<body>
<table style="margin: 0 7mm; width: 100%; border-collapse: collapse; color: {{ $gray['500'] }}; font-size: 9pt;">
    <tr style="vertical-align: top;">
        <td style="line-height: 1.3;" colspan="2">
            <p style="font-weight: 600; margin-bottom: 1mm; font-size: 10pt;">Conditions particulières</p>
            <p>TVA non applicable, article 293B du Code Général des Impôts.</p>
            <p>En conformité de l’article L 441-6 du Code de commerce :</p>
            <p>→ Paiement à 30 jours. Pas d’escompte pour règlement anticipé.</p>
            <p>→ En cas de retard de paiement, indemnité forfaitaire légale pour frais de recouvrement : 40€.</p>
            <p>→ Les pénalités de retard correspondent à : 2.37% du montant TTC.</p>
            <p>→ Dispensé d'immatriculation au RCS et au répertoire des métiers.</p>
        </td>
    </tr>

    <tr>
        <td style="padding-top: 3mm; font-variant-numeric: tabular-nums slashed-zero; width: 100%;">
            N° RNA W 162 001 110 • N° SIRET 813 684 388 00016 • N° TVA FR64 813 684 388 • CODE NAF 9312Z
        </td>
        <td style="padding-top: 3mm; font-variant-numeric: tabular-nums slashed-zero; text-align: right;">
            Page&nbsp;<span class="pageNumber"></span>/<span class="totalPages"></span>
        </td>
    </tr>
</table>
</body>
</html>
