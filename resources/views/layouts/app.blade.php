<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Hajatin.com adalah platform undangan digital online untuk membuat undangan pernikahan, ulang tahun, seminar, syukuran, grand opening, dan berbagai acara lainnya. Pilih template, edit data acara, tambahkan foto, lokasi Google Maps, RSVP, buku tamu, amplop digital, lalu bagikan undangan melalui link.">
        <meta name="keywords" content="undangan digital, undangan online, undangan pernikahan digital, undangan ulang tahun online, template undangan digital, undangan website, undangan dengan RSVP, undangan Google Maps, undangan amplop digital">
        <meta name="author" content="Spektakuler.id">

        <meta property="og:title" content="Hajatin.com - Platform Undangan Digital Online">
        <meta property="og:description" content="Buat undangan digital elegan untuk pernikahan, ulang tahun, seminar, syukuran, grand opening, dan berbagai acara lainnya.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
