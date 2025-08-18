<x-header />

@php
    $last = null;
    if ($latestAttempt && !empty($latestAttempt->actions)) {
        $last = $latestAttempt->actions[array_key_last($latestAttempt->actions)];
    }
@endphp


<div class="profile-main">
    <div class="profile-wrap">
        <div class="profile-title">
            <h2>Informacije o korisniku #{{ $user->id }}</h2>
        </div>

        <div class="profile-section-wrap">

            <div class="profile-section-teacher">
                <div class="profile-section-input-teacher">
                    <div class="profile-picture">
                        <img
                            src="{{ $user->profile_picture
                                ? asset('storage/' . $user->profile_picture)
                                : asset('images/auth_module/user_placeholder.png') }}"
                            alt="Profilna slika korisnika"
                        >
                    </div>
                </div>

                <div class="profile-section-input-teacher">
                    <label class="profile-label" for="email">E-mail adresa: </label>
                    <span class="status">{{ $user->email }}</span>
                </div>

                <div class="profile-section-input-teacher">
                    <label class="profile-label" for="full_name">Prezime i ime: </label>
                    <span class="status">{{ $user->full_name_formatted }}</span>
                </div>


                @if ($last)
                    <div class="profile-section-input-teacher student-activity">
                        <label class="profile-label">Zadnja aktivnost: </label>
                        <span class="status">Vrijeme: {{ $last['time'] }}</span>
                        <span class="status">Aktivnost: {{ $last['activity'] }}</span>
                    </div>
                @endif
            </div>

            <div class="profile-section-teacher">
                <div class="profile-section-input-teacher">
                    <label class="profile-label" for="pin_value">{{ $user->pin }}: </label>
                    <span class="status">{{ $user->pin_value }}</span>
                </div>

                <div class="profile-section-input-teacher">
                    <label class="profile-label" for="role">Uloga: </label>
                    <span class="status">{{ $user->role_formatted }}</span>
                </div>

                <div class="profile-section-input-teacher">
                    <label class="profile-label" for="gender">Spol: </label>
                    <span class="status">{{ $user->gender_formatted }}</span>
                </div>

                <div class="profile-section-input-teacher">
                    <label class="profile-label" for="status">Status: </label>
                    <span class="status">{{ $user->status_formatted }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
