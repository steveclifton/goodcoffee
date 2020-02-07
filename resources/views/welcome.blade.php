<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/base-min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:700|Open+Sans+Condensed:300|Quicksand|Roboto+Mono&display=swap" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>

        <script>
            var go_cafes = {!! json_encode($cafes) !!};
        </script>
        <script src="/js/app.js" defer></script>

    </body>
</html>
