<x-header />

<div align="center">
    <div>
        <form action="#">
            <div>
            <div>
                <h3>Registracija u aplikaciju</h3>
            </div>
            <div>
                <label for="oib">Unesite OIB: </label>
                <input type="text" name="oib" id="oib">
            </div>

            <div>
                <label for="name">Prezime i ime: </label>
                <input type="text" name="name" id="name">
            </div>

            <div>
                <label for="gender">Spol: </label>
                <input type="radio" name="gender"> Muški
                <input type="radio" name="gender"> Ženski
            </div>

            <div>
                <label for="password">Unesite lozinku: </label>
                <input type="password" name="password" id="password">
            </div>

            <div>
                <label for="password_confirm">Ponovite lozinku: </label>
                <input type="password" name="password_confirm" id="password_confirm">
            </div>
            <div>
                <button type="submit">Registriraj se</button>
            </div>
            </div>
        </form>
    </div>
</div>
