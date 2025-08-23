<x-header />

<div class="profile-main">
    <div class="profile-wrap">
        <div class="profile-title">
            <h2>Moj profil</h2>
        </div>

        <div class="profile-section-wrap">
            <div class="profile-section">
                    <form action="{{ route('users.edit_profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PATCH")
                <input type="hidden" name="pin" value="{{ auth()->user()->pin }}">
                <div class="profile-subsection">


                    <div class="profile-section-input">
                        <label class="profile-label" for="email">E-mail adresa: </label>
                        <input type="text" name="email" id="email" value="{{ $user->email }}">
                    </div>
                    @error('email')
                        <div class="error-div">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="profile-section-input">
                        <label class="profile-label" for="full_name">Prezime i ime: </label>
                        <input type="text" name="full_name" id="full_name" value="{{ $user->full_name_formatted }}">
                    </div>
                    @error('full_name')
                        <div class="error-div">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="profile-section-input">
                        <label class="profile-label" for="pin_value">{{ auth()->user()->pin }}: </label>
                        <input type="text" name="pin_value" id="pin_value" value="{{ $user->pin_value }}">
                    </div>

                    @error('pin_value')
                        <div class="error-div">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="profile-section-input">
                        <label class="profile-label" for="profile_picture">Slika profila:</label>

                        <div class="profile-picture">
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/auth_module/user_placeholder.png') }}" alt="">
                        </div>

                        <input
                            type="file"
                            name="profile_picture"
                            id="profile_picture"
                            accept="image/*"
                            style="display: none;"
                        >

                        <label for="profile_picture" class="custom-file-button auth-picture profile-label">Odaberi sliku</label>
                    </div>

                    @error('profile_picture')
                        <div class="error-div">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="profile-subsection">
                    <div class="profile-section-input">
                    <label class="profile-label" for="role">Uloga: </label>
                    <span class="status">{{ $user->role_formatted }}</span>
                </div>

                <div class="profile-section-input">
                    <label class="profile-label" for="gender">Spol: </label>
                    <div>
                        <input type="radio" name="gender" value="m" {{ $user->gender === 'm' ? 'checked' : '' }}> <span class="gender-span">Muški</span>
                        <input type="radio" name="gender" value="f" {{ $user->gender === 'f' ? 'checked' : '' }}> <span class="gender-span">Ženski</span>
                    </div>
                </div>

                @if (auth()->user()->role === 'student')
                    <div class="profile-section-input">
                    <label class="profile-label" for="status">Status: </label>
                    <div>
                        <input type="radio" name="status" value="i" {{ $user->status === 'i' ? 'checked' : '' }}> <span class="status-span">Izvanredan</span>
                        <input type="radio" name="status" value="r" {{ $user->status === 'r' ? 'checked' : '' }}> <span class="status-span">Redovan</span>
                    </div>
                </div>
                @elseif (auth()->user()->role === 'teacher' || auth()->user()->role === 'admin')
                    <div class="profile-section-input">
                        <label class="profile-label" for="status">Status: </label>
                        <span class="status">{{ $user->status_formatted }}</span>
                    </div>
                @endif

                    <div class="profile-action">
                        <button type="submit">Spremi promjene</button>
                    </div>
                    </form>
                </div>

                <div class="profile-subsection">
                    <form action="{{ route('users.update_password') }}" method="POST">
                        @csrf
                        @method("PATCH")
                        <div class="profile-section-input">
                            <label class="profile-label" for="password">Stara lozinka: </label>
                            <input type="password" name="password" id="password">
                        </div>
                        @error("password")
                            <div class="error-div">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="profile-section-input">
                            <label class="profile-label" for="new_password">Nova lozinka: </label>
                            <input type="password" name="new_password" id="new_password">
                        </div>

                        @error("new_password")
                            <div class="error-div">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="profile-section-input">
                            <label class="profile-label" for="new_password_repeat">Ponovi novu lozinku: </label>
                            <input type="password" name="new_password_repeat" id="new_password_repeat">
                        </div>

                        @error("new_password_repeat")
                            <div class="error-div">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="profile-action">
                            <button type="submit">Ažuriraj lozinku</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

