<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/assets/icons/logo.svg" type="image/svg+xml">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" sizes="180x180" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
    <script>

    </script>
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>