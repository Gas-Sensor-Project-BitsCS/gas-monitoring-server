<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/auth.css">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <title>Document</title>
</head>
<body>
    <div class="main">
    <div class="flex-center">
        <div>
            <h1 style="font-size: clamp(1.5rem, 2.5vw + 1rem, 2rem);">Mine safety</h1>
            <p class="title-para">Gas Leak Detection and Automatic evacuation System</p3>
        </div>
    </div>
    <div class="container">
    @yield('form')
    </div>
    </div>
    @stack('scripts')
</body>
</html>
