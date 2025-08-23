<x-header />

<div class="user-auth-main">
    <div class="user-auth-wrap">
        <form action="{{ route('auth.login') }}" method="POST">
        @csrf
            <input type="hidden" name="pin" value="OIB">
            <div class="user-auth-form-div">
                <h3>Prijava u aplikaciju - nastavnik/administrator</h3>
            </div>
            <div>
            <div class="user-auth-form-div">
                <label for="pin_value">Unesite OIB: </label>
                <input type="text" name="pin_value" id="pin_value" autocomplete="off">
            </div>
            @error('pin_value')
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
            <button class="user-auth-action" type="submit">Prijavi se</button>
        </div>
    </div>
        </form>
    </div>
</div>
