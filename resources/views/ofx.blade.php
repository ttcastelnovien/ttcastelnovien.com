<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body class="font-sans antialiased">
        <form method="POST" action="{{ route('public.ofx.post') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".ofx,.qfx" required>
            <button type="submit">Import OFX/QFX</button>
        </form>
    </body>
</html>
