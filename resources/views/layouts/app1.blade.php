<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="styles/normalize.min.css">
        <link rel="stylesheet" href="styles/index.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    $('.btn-primary').click(function(params) {
        $(this).hide()
        $(this).closest('.product').find('.count-button').show()
        product_id = $(this).closest('.product').attr('data-id')
        csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: '/cart/add',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                product_id: product_id
            },
            success: function(response) {
                console.log(response)
                $('.badge').text(response)
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    // Перенаправляем пользователя на страницу /register
                    window.location.href = "/register";
                } else {
                    console.error("Произошла ошибка при выполнении запроса:", error, status);
                }
            }
        })
    })
    $('.btn-outline-primary').click(function() {
        val = $(this).text()
        spoon = $(this).parent().find('span')
        if (val == '+') {
            spoon.text(parseInt(spoon.text()) + 1)
            $.ajax({
                type: 'POST',
                url: '/cart/add',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    console.log(response)
                    $('.badge').text(response)
                }
            })
        } else {
            spoon.text(parseInt(spoon.text()) - 1)
            if (!parseInt(spoon.text())) {
                $(this).closest('.count-button').hide()
                $(this).closest('.card').find('.btn-buy').show()
                spoon.text(parseInt(spoon.text()) + 1)
            }
        }
    })
</script>