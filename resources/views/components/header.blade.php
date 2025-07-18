<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Examino</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav>
        <div class="header-main">
            <div class="header-logo"></div>
            <div class="header-actions">
                <a class="header-button" href="{{ route('users.profile') }}">Moj profil</a>
                <a class="header-button" href="{{ route('auth.login_form') }}">Prijavi se</a>
                <a class="header-button" href="{{ route('auth.register_form') }}">Registriraj se</a>
            </div>
        </div>
    </nav>
</header>
</body>
