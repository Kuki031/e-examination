<x-header />

<div class="user-auth-main">
    <div class="user-auth-wrap">
        <form action="#">
            <div class="user-auth-form-div">
                <h3>Registracija u aplikaciju - nastavnik</h3>
            </div>
            <div>

            <div class="user-auth-form-div">
                <label for="email">Unesite e-mail adresu: </label>
                <input type="text" name="email" id="email" autocomplete="off">
            </div>
            <div class="user-auth-form-div">
                <label for="oib">Unesite OIB: </label>
                <input type="text" name="oib" id="oib" autocomplete="off">
            </div>

            <div class="user-auth-form-div">
                <label for="name">Unesite prezime i ime: </label>
                <input type="text" name="name" id="name" autocomplete="off">
            </div>

            <div class="user-auth-form-div">
                <div class="user-auth-radio-selection">
                    <label for="gender">Spol (označiti jedno): </label>
                    <div>
                        <div>
                            <input type="radio" name="gender" value="m"> Muški
                        </div>
                        <div>
                            <input type="radio" name="gender" value="f"> Ženski
                        </div>
                    </div>
                </div>
            </div>


            <div class="user-auth-form-div">
                <label for="password">Unesite lozinku: </label>
                <input type="password" name="password" id="password" autocomplete="off">
            </div>

            <div class="user-auth-form-div">
                <label for="password_confirm">Ponovite lozinku: </label>
                <input type="password" name="password_confirm" id="password_confirm" autocomplete="off">
            </div>

            <div class="user-auth-form-div">
                <button class="user-auth-action" type="submit">Registriraj se</button>
            </div>
            </div>
        </form>
    </div>
</div>
