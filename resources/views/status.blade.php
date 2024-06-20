<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ config('app.name', 'Encurtador-MK') }}
    </title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <h2>API</h2>
        <p>
            Documentação simples e intuitiva para a API do Encurtador-MK.
            <a href="/docs/api/">Clique aqui</a> para acessar.
        </p>
    </div>
    <hr>
    <div class="container">

        <div class="card">
            <h2>URL</h2>
            <p>
                <a href="{{ config('app.url') . '/' . $url->short_url }}" target="_blank">
                  {{ config('app.url') . '/' . $url->short_url }}</a>
            </p>

            <h2>Cliques na URL</h2>
            <p>
                {{ $url->visits }}
            </p>

        </div>

    </div>

</html>

</html>
