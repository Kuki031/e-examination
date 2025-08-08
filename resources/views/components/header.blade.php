<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Examino</title>
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav>
        <div class="header-main">
            <div class="header-actions">
                <div class="header-logo"></div>
                <div class="header-index">
                    <a class="header-button" href="{{ route('index') }}">Naslovnica</a>
                </div>
            </div>

            @auth
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                    <div>
                        <a class="header-button" href="{{ route('teacher.teacher_exams') }}">Moje provjere znanja</a>
                        <a class="header-button" href="{{ route('teacher.new_exam') }}">Nova provjera znanja</a>
                        <a class="header-button" href="#">Provedene provjere znanja</a>
                    </div>
                @endif
            @endauth

            @auth
                @if (auth()->user()->role === 'student')
                    <div>
                        <a class="header-button" href="{{ route('exams.list') }}">Dostupne provjere znanja</a>
                        <a class="header-button" href="#">Rezultati</a>
                    </div>
                @endif
            @endauth

            <div class="header-actions">
                @auth
                    @if (auth()->user()['role'] === 'admin')
                        <div class="header-requests">
                            <a class="header-button" href="{{ route('admin.new_users_list') }}">Korisnici</a>
                            <div class="header-requests-notification">
                                <span id="request-number"></span>
                            </div>
                        </div>
                    @endif
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
