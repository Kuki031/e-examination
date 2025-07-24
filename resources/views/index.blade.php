<x-header />

<div class="index-main">
    <div class="index-wrap">
        @if (auth()->user())
        <div class="index-text-user">
            <h2>Dobrodošao/la {{ auth()->user()?->full_name_formatted }}</h2>
        </div>
        @endif
        <div class="index-text">
                <div>
                    <h2>Dobrodošli u Examino!</h2>
                </div>
                <div>
                    <p>Examino je web aplikacija razvijena u sklopu diplomskog rada iz kolegija <i><b>Razvoj web aplikacija</b></i>.</p>
                </div>
                <div>
                    <p>Korištene tehnologije: </p>
                    <ul class="index-list">
                        <div>
                        <li>Laravel 12 (PHP)</li>
                        <li>MySQL</li>
                        <li>Blade</li>
                        <li>JavaScript</li>
                        <li>CSS</li>
                        </div>
                    </ul>
                </div>
                <div>
                    Tema rada je <i><b>Web aplikacija za e-učenje</b></i>.
                </div>
                @if (!auth()->user())
                    <div>
                        <p>Kako bi ste mogli koristiti sve značajke aplikacije, potrebno je <a href="{{ route('auth.login_selector') }}">prijaviti</a> se u aplikaciju.</p>
                    </div>
                    <div>
                        <p>U slučaju da nemate korisnički račun, morate se <a href="{{ route('auth.register_selector') }}">registrirati</a>.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
