<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <title>
            {{ config('app.name', 'Laravel') }}
        </title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#8888DD">

        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon/apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <div id="app">
            <home-page />
        </div>
    </body>
</html>
