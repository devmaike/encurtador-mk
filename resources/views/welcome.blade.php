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
        <div>
            <h1>Encurtador-MK</h1>
            <p>
                Simplesmente insira a URL original e clique em "Encurtar".
            </p>
        </div>
        <div>
            <div>
                <label for="url">URL Original</label>
                <input id="url" class="input-url" placeholder="https://devmk.me" required="" type="url">
            </div>
            <div>
                <label for="apelido">Apelido (opcional)</label>
                <input id="apelido" placeholder="Encurtador-MK">
            </div>
            <div>
                <label for="expires">Data de Expiração (opcional)</label>
                <input class="input-date" id="expires" type="date">
            </div>
            <div>
                <button class="primary-button" type="submit" id="submit">Encurtar</button>
            </div>

            <div class="" id="short-url" style="display: none;">
                <label for="url_short">URL Encurtada</label>
                <input id="url_short" class="input-url" placeholder="https://example.com" required="" type="url">
                <button class="secondary-button" id="copy">Copiar URL</button>
            </div>
        </div>



    </div>

    <hr>
    <div class="container">
        <h2>API</h2>
        <p>
            Documentação simples e intuitiva para a API do Encurtador-MK.
            <a href="/docs/api/">Clique aqui</a> para acessar.
        </p>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function submit() {
            var url_original = $('.input-url').val();
            var data_expiracao = $('.input-date').val();
            var apelido = $('#apelido').val();
            $.ajax({
                url: "{{ route('urls.store') }}",
                type: "POST",
                data: {
                    url_original: url_original,
                    data_expiracao: data_expiracao,
                    apelido: apelido,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#short-url').show();
                    $('#url_short').val(response.short_url);
                },
                error: function(response) {
                    if (response.responseJSON.error) {
                        alert(response.responseJSON.error);
                    } else {
                        alert(response.responseJSON.message);
                    }
                }
            });
        }
    </script>
</body>

</html>

</html>
