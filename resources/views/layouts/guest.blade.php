<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-vignette') }}</title>

        <!-- Fonts -->

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->    
        @vite(['resources/css/app.css'])
        @vite(['resources/css/float.css'])
        @vite(['resources/css/gsap.css'])
    </head>
    <body class="font-sans text-gray-900 "> 

        <div class="container">
            <nav>
                <div class="logo">
                    <span>E-vignette</span>
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">singup</a></li>
                    </ul>
                </div>
            </nav>
        </div>
       
        <div id="content">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
