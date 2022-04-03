<!DOCTYPE html>
<!-- prettier-ignore -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ config("app.name", "Fitness Tracker") }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="w-[320px] sm:w-[425px] flex h-screen mx-auto flex-col">
        <div x-data="contactUsForm({ csrfToken: '{{csrf_token()}}' })">
            <button @click="showModal = true" class="app-btn app-btn-primary absolute top-5 right-5">Contact Us</button>
            <x-contact-us />
        </div>
        @yield('main-content')
        @yield('script')
    </body>
</html>
