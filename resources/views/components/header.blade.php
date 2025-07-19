<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Examino</title>
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav>
        <div class="header-main">
            <div class="header-logo"></div>
            <div class="header-actions">

                @auth
                    <a class="header-button" href="{{ route('users.profile') }}">Moj profil</a>
                    <a id="log-out" class="header-button" href="#">Odjavi se</a>

                @endauth

                @if (!auth()->check())
                    <a class="header-button" href="{{ route('auth.login_selector') }}">Prijava</a>
                    <a class="header-button" href="{{ route('auth.register_selector') }}">Registracija</a>
                @endif
            </div>
        </div>
    </nav>
</header>
</body>
