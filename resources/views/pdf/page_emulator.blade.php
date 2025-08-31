<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
        }

        html {
            background-color: #494949
        }

        body {
            width: 210mm;
            margin: 0 auto;
            padding: 5mm;
            box-sizing: border-box;
            font-family: "Bricolage Grotesque", sans-serif;
            font-size: 11pt;
            color: #334155;
            background-color: #ffffff;
        }
    </style>
</head>
<body>
@include('pdf.formulaire_licence.header')
@include('pdf.formulaire_licence.content')
@include('pdf.formulaire_licence.footer')
</body>
</html>

