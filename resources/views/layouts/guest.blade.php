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
    <body class="w-[95%] sm:w-[525px] flex h-screen mx-auto flex-col bg-stone-800">
        <div x-data="contactUsForm({ postContactUsFormURL: '{{route('storeContactUsForm')}}' })">
            <button @click="showModal = true; $dispatch('close-reset-modal')" x-bind:disabled="showModal" class="app-btn app-btn-secondary absolute top-5 right-5">Contact Us</button>
            <x-contact-us />
        </div>
        <x-forgot-password />
        @yield('main-content')
        
        @yield('script')
    </body>
</html>
