<x-header />

<div class="user-auth-main">
    <div class="user-auth-wrap">
        <form action="{{ route('auth.register') }}" method="POST">
            @csrf
            <input type="hidden" name="pin" value="OIB">
            <input type="hidden" name="status" value="n">
            <div class="user-auth-form-div">
                <h3>Registracija u aplikaciju - nastavnik</h3>
            </div>
            <div>

            <div class="user-auth-form-div">
                <label for="email">Unesite e-mail adresu: </label>
                <input type="text" name="email" id="email" autocomplete="off" value="{{ old('email') }}">
            </div>

            @error('email')
                <div class="error-div">
                    <span>{{ $message }}</span>
                </div>
            @enderror

            <div class="user-auth-form-div">
                <label for="pin_value">Unesite OIB: </label>
                <input type="text" name="pin_value" id="pin_value" autocomplete="off" value="{{ old('pin_value') }}">
            </div>

            @error('pin_value')
                <div class="error-div">
                    <span>{{ $message }}</span>
                </div>
            @enderror

            <div class="user-auth-form-div">
                <label for="full_name">Unesite prezime i ime: </label>
                <input type="text" name="full_name" id="full_name" autocomplete="off" value="{{ old('full_name') }}">
            </div>

            @error('full_name')
                <div class="error-div">
                    <span>{{ $message }}</span>
                </div>
            @enderror

            <div class="user-auth-form-div">
                <div class="user-auth-radio-selection">
                    <label for="gender">Spol (označiti jedno): </label>
                    <div>
                        <div>
                            <input type="radio" name="gender" value="m" {{ old('gender') === 'm' ? 'checked' : '' }}> Muški
                        </div>
                        <div>
                            <input type="radio" name="gender" value="f" {{ old('gender') === 'f' ? 'checked' : '' }}> Ženski
                        </div>
                    </div>
                </div>
            </div>

            @error('gender')
                <div class="error-div">
                    <span>{{ $message }}</span>
                </div>
            @enderror


            <div class="user-auth-form-div">
                <label for="password">Unesite lozinku: </label>
                <input type="password" name="password" id="password" autocomplete="off">
            </div>

            @error('password')
                <div class="error-div">
                    <span>{{ $message }}</span>
                </div>
            @enderror

            <div class="user-auth-form-div">
                <label for="password_confirm">Ponovite lozinku: </label>
                <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="off">
            </div>

            <div class="user-auth-form-div">
                <button class="user-auth-action" type="submit">Registriraj se</button>
            </div>
            </div>
        </form>
    </div>
</div>
