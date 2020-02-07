<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

    </head>
    <body>
        <div id="app">
            <router-view></router-view>

            <hr>
            <router-link to="/cafe">Cafe</router-link>
            <router-link to="/">Home</router-link>
        </div>

        <script>
            var go_cafes = {!! json_encode($cafes) !!};
        </script>
        <script src="/js/app.js" defer></script>

    </body>
</html>
