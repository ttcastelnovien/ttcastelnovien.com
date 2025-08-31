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
<table
    style="table-layout: fixed; width: 100%; font-size: 10pt; border-collapse: collapse; margin-top: 10mm; margin-bottom: 10mm;">

    <tr style="vertical-align: top;">
        <td>
            <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                <tr style="vertical-align: top;">
                    <td colspan="2"
                        style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                        Informations personnelles
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td style="padding: 3mm 3mm 3mm 3mm; border-left: 1pt dashed {{ $gray['500'] }}; border-bottom: 1pt dashed {{ $gray['500'] }};">
                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Nom</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->last_name }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Nom de naissance</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->birth_name ?? $licence->person->last_name }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Prénom</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->first_name }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Sexe</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->sex->getLabel() }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Adresse e-mail</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->email }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Téléphone</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->phone }}
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td style="padding: 3mm 3mm 3mm 3mm; border-right: 1pt dashed {{ $gray['500'] }}; border-bottom: 1pt dashed {{ $gray['500'] }};">
                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Date de naissance</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->birth_date->isoFormat('L') }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Ville de naissance (et
                                    code
                                    postal)
                                </td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->birth_city }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Adresse</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    <p>{{ $licence->person->address_line_1 }}</p>
                                    @if($licence->person->address_line_2)
                                        <p>{{ $licence->person->address_line_2 }}</p>
                                    @endif
                                    @if($licence->person->address_line_3)
                                        <p>{{ $licence->person->address_line_3 }}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Code postal</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->postal_code }}
                                </td>
                            </tr>
                        </table>

                        <table
                            style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                            <tr style="vertical-align: top;">
                                <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Ville</td>
                                <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                    {{ $licence->person->city }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @if($licence->person->is_minor)
        @php
            $first_parent = $licence->person->parents->first();
            $second_parent = $licence->person->parents->skip(1)->first();
        @endphp
        <tr style="vertical-align: top;">
            <td style="padding-top: 5mm;">
                <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                    <tr style="vertical-align: top;">
                        <td colspan="2"
                            style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                            Responsables légaux
                        </td>
                    </tr>

                    <tr style="vertical-align: top;">
                        <td style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                            Responsable légal 1
                        </td>
                        <td style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                            Responsable légal 2
                        </td>
                    </tr>

                    <tr style="vertical-align: top;">
                        <td style="padding: 3mm 3mm 3mm 3mm; border: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Nom</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $first_parent?->last_name ?? '' }}
                                    </td>
                                </tr>
                            </table>

                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Prénom</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $first_parent?->first_name ?? '' }}
                                    </td>
                                </tr>
                            </table>

                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Date de naissance</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $first_parent?->birth_date?->isoFormat('L') ?? '' }}
                                    </td>
                                </tr>
                            </table>

                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Adresse e-mail</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $first_parent?->email ?? '' }}
                                    </td>
                                </tr>
                            </table>

                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Téléphone</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $first_parent?->phone ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="padding: 3mm 3mm 3mm 3mm; border: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Nom</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $second_parent?->last_name ?? '' }}
                                    </td>
                                </tr>
                            </table>

                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Prénom</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $second_parent?->first_name ?? '' }}
                                    </td>
                                </tr>
                            </table>

                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Date de naissance</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $second_parent?->birth_date?->isoFormat('L') ?? '' }}
                                    </td>
                                </tr>
                            </table>

                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom: 4mm;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Adresse e-mail</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $second_parent?->email ?? '' }}
                                    </td>
                                </tr>
                            </table>

                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 38mm; font-weight: 600; margin-right: 2mm;">Téléphone</td>
                                    <td style="text-wrap: pretty; margin-left: 2mm; border-bottom: 1pt solid {{ $gray['300'] }}; font-variant-numeric: tabular-nums slashed-zero;">
                                        {{ $second_parent?->phone ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif

    <tr style="vertical-align: top;">
        <td style="padding-top: 5mm;">
            <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                <tr style="vertical-align: top;">
                    <td style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                        Certification médicale
                    </td>
                </tr>

                @if($licence->medical_certificate !== null && $licence->health_declaration === null && $licence->person->medicalCertificates->isEmpty())
                    <tr style="vertical-align: top;">
                        <td style="padding: 3mm; border: 1pt dashed {{ $gray['500'] }};">
                            Vous n'avez pas de certificat médical enregistré les saisons précédentes.
                            Vous devez fournir un certificat médical de moins de 3 mois précisant la pratique du Tennis
                            de Table en compétition.
                        </td>
                    </tr>
                @elseif($licence->medical_certificate !== null && $licence->health_declaration === null && $licence->person->medicalCertificates->isNotEmpty())
                    <tr style="vertical-align: top;">
                        <td style="padding: 3mm; border: 1pt dashed {{ $gray['500'] }};">
                            Votre précédent certificat médical n'est plus valide (plus de 5 ans ou changement de
                            catégorie).
                            Vous devez fournir un certificat médical de moins de 3 mois précisant la pratique du Tennis
                            de Table en compétition.
                        </td>
                    </tr>
                @elseif($licence->medical_certificate === null && $licence->health_declaration !== null)
                    <tr style="vertical-align: top;">
                        <td style="padding: 3mm; border: 1pt dashed {{ $gray['500'] }};">
                            <p style="margin-bottom: 5mm; padding-bottom: 3mm; border-bottom: 1pt solid {{ $gray['500'] }};">
                                Si vous pensez
                                répondre OUI à l'une des questions suivantes,
                                vous devez fournir un
                                certificat médical de moins de 3 mois précisant la pratique du Tennis de Table en
                                compétition. Sinon cochez la case attestant que vous répondez NON à l'ensemble des
                                interrogations.</p>

                            @if($licence->person->is_minor)
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr style="vertical-align: top;">
                                        <td colspan="2"
                                            style="padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500;">
                                            Durant les 12 derniers mois
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            01
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Es-tu allé(e) à l'hôpital pendant toute
                                            une journée ou
                                            plusieurs jours ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            02
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu été opéré(e) ?</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            03
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu beaucoup plus grandi que les autres
                                            années ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            04
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu beaucoup maigri ou grossi ?</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            05
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu eu la tête qui tourne pendant un
                                            effort ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            06
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu perdu connaissance ou es-tu tombé
                                            sans te souvenir de ce qui s'était passé ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            07
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu reçu un ou plusieurs chocs violents
                                            qui t'ont obligé à interrompre un moment une séance de sport?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            08
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu eu beaucoup de mal à respirer
                                            pendant un effort par rapport à d'habitude ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            09
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu eu beaucoup de mal à respirer après
                                            un effort ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            10
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu eu mal dans la poitrine ou des
                                            palpitations (le cœur qui bat très vite) ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            11
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu commencé à prendre un nouveau
                                            médicament tous les jours et pour longtemps ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            12
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu arrêté le sport à cause d'un
                                            problème de santé pendant un mois ou plus ?
                                        </td>
                                    </tr>

                                    <tr style="vertical-align: top;">
                                        <td colspan="2" style="height: 3mm;"></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td colspan="2"
                                            style="padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500;">
                                            Depuis plus de 2 semaines
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            13
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Te sens-tu très fatigué(e) ?</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            14
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">As-tu du mal à t'endormir ou te
                                            réveilles-tu souvent dans la nuit ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            15
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Sens-tu que tu as moins faim ? que tu
                                            manges moins ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            16
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Te sens-tu triste ou inquiet ?</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            17
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Pleures-tu plus souvent ?</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            18
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Ressens-tu une douleur ou un manque de
                                            force à cause d'une blessure que tu t'es faite cette année?
                                        </td>
                                    </tr>

                                    <tr style="vertical-align: top;">
                                        <td colspan="2" style="height: 3mm;"></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td colspan="2"
                                            style="padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500;">
                                            Aujourd'hui
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            19
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Penses-tu quelquefois à arrêter de faire
                                            du sport ou à changer de sport ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            20
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Penses-tu avoir besoin de voir ton médecin
                                            pour continuer le sport ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            21
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Souhaites-tu signaler quelque chose de
                                            plus concernant ta santé ?
                                        </td>
                                    </tr>

                                    <tr style="vertical-align: top;">
                                        <td colspan="2" style="height: 3mm;"></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td colspan="2"
                                            style="padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500;">
                                            Questions pour les parents
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            22
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Quelqu'un dans votre famille proche a-t-il
                                            eu une maladie grave du cœur ou du cerveau, ou est-il
                                            décédé subitement avant l'âge de 50 ans ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            23
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Êtes-vous inquiet pour son poids ?
                                            Trouvez-vous qu'il se nourrit trop ou pas assez ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            24
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Avez-vous manqué l'examen de santé prévu à
                                            l'âge de votre enfant chez le médecin ?<br><span
                                                style="font-size: 9pt; color: {{ $gray['500'] }}">Cet examen médical est prévu à l'âge de 2 ans, 3 ans, 4 ans, 5 ans, entre 8 et 9 ans, entre 11 et 13 ans et entre 15 et 16 ans.</span>
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr style="vertical-align: top;">
                                        <td colspan="2"
                                            style="padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500;">
                                            Durant les 12 derniers mois
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            01
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Un membre de votre famille est-il décédé
                                            subitement d'une cause cardiaque ou inexpliquée ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            02
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Avez-vous ressenti une douleur dans la
                                            poitrine, des palpitations, un essouflement inhabituel ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            03
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Avez-vous eu un épisode de respiration
                                            sifflante ( asthme ) ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            04
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Avez-vous eu une perte de connaissance ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            05
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Si vous avez arrêté le sport pendant 30
                                            jours ou plus pour des raisons de santé, avez-vous
                                            repris sans l'accord d'un médecin ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            06
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Avez-vous débuté un traitement médical de
                                            longue durée ( hors contraception et
                                            désensibilisation aux allergies ) ?
                                        </td>
                                    </tr>

                                    <tr style="vertical-align: top;">
                                        <td colspan="2" style="height: 3mm;"></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td colspan="2"
                                            style="padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500;">
                                            À ce jour
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            07
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Ressentez-vous une douleur, un manque de
                                            force ou une raideur suite a un problème osseux,
                                            articulaire ou musculaire ( fracture, entorse, luxation, déchirure,
                                            tendinite, etc. ), survenue
                                            durant les 12 derniers mois ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            08
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Votre pratique sportive est-elle
                                            interrompue pour des raisons de santé ?
                                        </td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td style="width: 10mm; padding: 1mm 1mm 1mm 3mm; border-left: 2pt solid {{ $gray['500'] }}; text-transform: uppercase; font-weight: 500; font-variant-numeric: tabular-nums slashed-zero;">
                                            09
                                        </td>
                                        <td style="padding: 1mm 1mm 1mm 3mm;">Pensez-vous avoir besoin d'un avis médical
                                            pour poursuivre votre pratique sportive ?
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <table
                                style="width: 100%; border-collapse: collapse; margin-top: 5mm; border-top: 1pt solid {{ $gray['500'] }};">
                                <tr style="vertical-align: top;">
                                    <td style="padding-top: 4mm;">
                                        <div
                                            style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                    </td>
                                    <td style="padding: 4mm 0 0 3mm">Je déclare
                                        avoir répondu
                                        NON à l'ensemble des questions de ce questionnaire. Je sais qu'à travers cette
                                        attestation, j'engage ma propre
                                        responsabilité et qu'en aucun cas celle de la FFTT ne pourra être recherchée.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>

    @if($licence->person->is_minor)
        <tr style="vertical-align: top;">
            <td style="padding-top: 5mm;">
                <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                    <tr style="vertical-align: top;">
                        <td colspan="2"
                            style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                            Autorisation de sortie pour mineur
                        </td>
                    </tr>

                    <tr style="vertical-align: top;">
                        <td style="padding: 3mm 3mm 3mm 3mm; border-left: 1pt dashed {{ $gray['500'] }}; border-bottom: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td>
                                        <div
                                            style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                    </td>
                                    <td style="padding-left: 3mm"><span style="font-weight: 700;">J’autorise</span> mon
                                        enfant à effectuer seul les trajets d’aller et de retour entre l'un des
                                        domiciles
                                        mentionnés ci-dessus et la salle de Tennis de Table lorsqu’il participe aux
                                        entraînements et aux
                                        diverses sorties. Je déclare avoir connaissance du fait qu’alors, la
                                        responsabilité du club et de
                                        l’encadrement ne pourra pas être engagée en cas d’accident survenu au cours
                                        desdits trajets.
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="padding: 3mm 3mm 3mm 3mm; border-right: 1pt dashed {{ $gray['500'] }}; border-bottom: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td>
                                        <div
                                            style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                    </td>
                                    <td style="padding-left: 3mm"><span
                                            style="font-weight: 700;">Je n'autorise pas</span> mon enfant à effectuer
                                        seul les trajets d’aller et de retour entre l'un des domiciles
                                        mentionnés ci-dessus et la salle de Tennis de Table lorsqu’il participe aux
                                        entraînements et aux
                                        diverses sorties. En conséquence, je m’engage à assurer moi-même l’encadrement
                                        dudit mineur
                                        à ces occasions. Si exceptionnellement une modification de cette situation
                                        devait intervenir, je
                                        m’engage à faire parvenir antérieurement un écrit à l’encadrement faisant état
                                        de cette
                                        modification temporaire.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr style="vertical-align: top;">
            <td style="padding-top: 5mm;">
                <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                    <tr style="vertical-align: top;">
                        <td colspan="2"
                            style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                            Autorisation de soins pour mineur
                        </td>
                    </tr>

                    <tr style="vertical-align: top;">
                        <td colspan="2"
                            style="padding: 3mm 3mm 3mm 3mm; border: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td>
                                        <div
                                            style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                    </td>
                                    <td style="padding-left: 3mm"><span style="font-weight: 700;">J’autorise</span> les
                                        responsables de l’association présents sur place, s’ils n’ont pas
                                        pu contacter l'un(e) des responsables légaux mentionnés ci-dessus, à prendre
                                        toutes décisions nécessaires en cas de maladie(s), blessure(s) ou
                                        d’accident(s) survenus pendant l’activité sportive, y compris l’hospitalisation.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr style="vertical-align: top;">
            <td style="padding-top: 5mm;">
                <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                    <tr style="vertical-align: top;">
                        <td colspan="2"
                            style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                            Autorisation de transport pour mineur
                        </td>
                    </tr>

                    <tr style="vertical-align: top;">
                        <td style="padding: 3mm 3mm 3mm 3mm; border-left: 1pt dashed {{ $gray['500'] }}; border-bottom: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td>
                                        <div
                                            style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                    </td>
                                    <td style="padding-left: 3mm"><span style="font-weight: 700;">J’autorise</span> mon
                                        enfant à être transporté dans le
                                        véhicule personnel d’un membre du conseil
                                        d’administration de l’association ou d’un parent bénévole pour les déplacements
                                        inhérents aux
                                        activités de l’association tout au long de la saison.
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="padding: 3mm 3mm 3mm 3mm; border-right: 1pt dashed {{ $gray['500'] }}; border-bottom: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td>
                                        <div
                                            style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                    </td>
                                    <td style="padding-left: 3mm"><span
                                            style="font-weight: 700;">Je n'autorise pas</span> mon enfant à être
                                        transporté dans le
                                        véhicule personnel d’un membre du
                                        conseil d’administration de l’association ou d’un parent bénévole pour les
                                        déplacements
                                        inhérents aux activités de l’association tout au long de la saison.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif

    @if($licence->image_rights !== null)
        <tr style="vertical-align: top;">
            <td style="padding-top: 5mm;">
                <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                    <tr style="vertical-align: top;">
                        <td colspan="2"
                            style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                            Autorisation de droit à l'image
                        </td>
                    </tr>

                    <tr style="vertical-align: top;">
                        <td style="padding: 3mm 3mm 0 3mm; border-left: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></td>
                                    @if($licence->person->is_minor)
                                        <td style="padding-left: 3mm; font-weight: 700;">J’autorise au nom de mon
                                            enfant
                                        </td>
                                    @else
                                        <td style="padding-left: 3mm; font-weight: 700;">J’autorise</td>
                                    @endif
                                </tr>
                            </table>
                        </td>

                        <td style="padding: 3mm 3mm 0 3mm; border-right: 1pt dashed {{ $gray['500'] }};">
                            <table
                                style="width: 100%; border-collapse: collapse;">
                                <tr style="vertical-align: top;">
                                    <td style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></td>
                                    @if($licence->person->is_minor)
                                        <td style="padding-left: 3mm; font-weight: 700;">Je n’autorise pas au nom de mon
                                            enfant
                                        </td>
                                    @else
                                        <td style="padding-left: 3mm; font-weight: 700;">Je n’autorise pas</td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr style="vertical-align: top;">
                        <td colspan="2"
                            style="padding: 3mm 3mm 3mm 3mm; border-left: 1pt dashed {{ $gray['500'] }}; border-right: 1pt dashed {{ $gray['500'] }}; border-bottom: 1pt dashed {{ $gray['500'] }};">
                            <p>l’association à fixer, diffuser, reproduire et communiquer au public les films,
                                les photographies pris(es) dans le cadre des activités de l’association et/ou les
                                paroles que j'ai
                                prononcées dans ce même cadre.</p>
                            <p>Les photographies, films et/ou interviews pourront être exploité(e)s et utilisé(e)s
                                directement par les
                                membres du conseil d’administration de l’association sous toute forme et tous supports
                                connus et
                                inconnus à ce jour, notamment de télédiffusion, de papier (journaux et périodiques) et
                                électronique (site
                                internet et réseaux sociaux), dans le monde entier, sans aucune limitation,
                                intégralement ou par extraits,
                                pour une durée de 5 ans à compter de la signature de la présente autorisation.</p>
                            <p>Ces supports pourront en aucun cas être cédé(e)s à des tiers, hors instances fédérales
                                (Comité, Ligue
                                ou Fédération).</p>
                            <p>L’association s'interdit expressément de procéder à une exploitation des photographies,
                                films et/ou
                                interviews susceptibles de porter atteinte à ma vie privée ou à ma réputation, ni
                                d'utiliser les
                                photographies, films et/ou interviews objets de la présente dans tout support à
                                caractère
                                pornographique, raciste, xénophobe ou tout autre exploitation préjudiciable.</p>
                            <p>Elle encouragera ses partenaires à faire de même et mettra en œuvre tous les moyens
                                nécessaires à la
                                réalisation de cet objectif.</p>
                            <p>Je me reconnais entièrement rempli de mes droits et je ne pourrai prétendre à aucune
                                rémunération pour
                                l'exploitation des droits visés aux présentes.</p>
                            <p>L’autorisation pourra être retirée à tout moment sur simple demande écrite auprès du
                                conseil
                                d’administration.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif

    <tr style="vertical-align: top;">
        <td style="padding-top: 5mm;">
            <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                <tr style="vertical-align: top;">
                    <td colspan="2"
                        style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                        Acceptations diverses
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td style="padding: 3mm 3mm 3mm 3mm; border: 1pt dashed {{ $gray['500'] }};">
                        <table
                            style="width: 100%; border-collapse: collapse;">
                            <tr style="vertical-align: top;">
                                <td>
                                    <div
                                        style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                </td>
                                <td style="padding-left: 3mm">J'atteste avoir pris connaissance
                                    des conditions et
                                    des garanties d'assurance ainsi que de la
                                    possibilité de souscrire une garantie
                                    complémentaire <span
                                        style="font-weight: 700;">(obligatoire)</span>
                                </td>
                            </tr>
                        </table>
                        <table
                            style="width: 100%; border-collapse: collapse;">
                            <tr style="vertical-align: top;">
                                <td style="padding-top: 4mm;">
                                    <div
                                        style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                </td>
                                <td style="padding: 4mm 0 0 3mm">J'accepte que mes coordonnées soient utilisées
                                    par la FFTT à des fins associatives
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="padding: 3mm 3mm 3mm 3mm; border: 1pt dashed {{ $gray['500'] }};">
                        <table
                            style="width: 100%; border-collapse: collapse;">
                            <tr style="vertical-align: top;">
                                <td>
                                    <div
                                        style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                </td>
                                <td style="padding-left: 3mm">Je refuse à la Fédération la prise de vues et
                                    l'utilisation de celles-ci dans le cadre des
                                    publications fédérales, dans le respect de la
                                    personne
                                </td>
                            </tr>
                        </table>
                        <table
                            style="width: 100%; border-collapse: collapse;">
                            <tr style="vertical-align: top;">
                                <td style="padding-top: 4mm;">
                                    <div
                                        style="width: 5mm; height: 5mm; border: 1pt solid {{ $gray['500'] }};"></div>
                                </td>
                                <td style="padding: 4mm 0 0 3mm">J'accepte que mes coordonnées soient utilisées
                                    par la FFTT à des fins commerciales
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr style="vertical-align: top;">
        <td style="padding-top: 5mm;">
            <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                <tr style="vertical-align: top;">
                    <td colspan="{{ $licence->person->is_minor ? 4 : 2 }}"
                        style="padding: 1.5mm 4mm; border: 1pt dashed {{ $gray['500'] }}; background-color: {{ $gray['100'] }}; text-transform: uppercase; font-weight: 700; text-align: center">
                        Signatures
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td style="padding: 1mm 2mm; border: 1pt dashed {{ $gray['500'] }}; font-weight: 700; text-transform: uppercase; text-align: center;">
                        Licencié
                    </td>
                    @if($licence->person->is_minor)
                        <td style="padding: 1mm 2mm; border: 1pt dashed {{ $gray['500'] }}; font-weight: 700; text-transform: uppercase; text-align: center;">
                            Responsable 1
                        </td>
                        <td style="padding: 1mm 2mm; border: 1pt dashed {{ $gray['500'] }}; font-weight: 700; text-transform: uppercase; text-align: center;">
                            Responsable 2
                        </td>
                    @endif
                    <td style="padding: 1mm 2mm; border: 1pt dashed {{ $gray['500'] }}; font-weight: 700; text-transform: uppercase; text-align: center;">
                        Tampon club
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td style="height: 30mm; border: 1pt dashed {{ $gray['500'] }}; font-weight: 700; text-transform: uppercase;"></td>
                    @if($licence->person->is_minor)
                        <td style="height: 30mm; border: 1pt dashed {{ $gray['500'] }}; font-weight: 700; text-transform: uppercase;"></td>
                        <td style="height: 30mm; border: 1pt dashed {{ $gray['500'] }}; font-weight: 700; text-transform: uppercase;"></td>
                    @endif
                    <td style="height: 30mm; border: 1pt dashed {{ $gray['500'] }}; font-weight: 700; text-transform: uppercase;"></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr style="vertical-align: top;">
        <td style="font-size: 9pt; color: {{ $gray['500'] }}; padding-top: 5mm; text-align: justify;">
            Les données à caractère personnel (nom, prénom, date de
            naissance, sexe, nationalité, adresse postale, courriel) sont
            indispensables à la délivrance de votre licence par la FFTT.
            Par la présente demande de licence, vous êtes informé de
            la publication de vos résultats obtenus au cours des
            compétitions en lien avec celle-ci sur les supports officiels
            de la FFTT ou agréés par celle-ci, ainsi que les supports du
            club. Ces résultats feront apparaître vos nom, prénom,
            catégorie d’âge et club.
            En vertu du droit à l'oubli, vous avez le droit de demander
            à la FFTT l'effacement de vos données à caractère
            personnel (nom, date de naissance, sexe, nationalité,
            adresse postale, téléphone, courriel). Pour cela, merci de
            vous adresser à votre organisme gestionnaire.
            En cas de non renouvellement de licence, ces données à
            caractère personnel seront conservées par la FFTT
            jusqu'à la fin de la saison suivante ; elles seront ensuite
            inaccessibles.
        </td>
    </tr>

</table>
</body>
</html>
