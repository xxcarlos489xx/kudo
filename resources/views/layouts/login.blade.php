<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kudo| @yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="author" href="Carlos Villanueva" />
        <meta http-equiv="Content-Language" content="es"/>
        <meta name="author" content="Carlos Villanueva"/>
        <meta name="description" content="Challengue Kudo"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="Kudo dashboard"/>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/auth/app.css') }}">
    </head>
    <style>
        
    </style>
    <body class="container-fluid d-flex justify-content-center align-items-center">
            @yield('content')
    </body>
        
@stack('scripts')

</html>
