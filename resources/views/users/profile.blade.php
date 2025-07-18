<x-header />

<div align="center">
    <div>
        <form action="#">
            <div>
                <h3>Osnovne informacije</h3>
            </div>
            <div>
                <label for="name">Prezime i ime: </label>
                <input type="text" name="name" id="name">
            </div>
            <div>
                <label for="oib">OIB/JMBAG: </label>
                <input type="text" name="oib" id="oib">
            </div>

            <div>
                <label for="profile_picture">Slika: </label>
                <input type="file" name="profile_picture" id="profile_picture">
            </div>
            <div>
                <label for="role">Uloga: </label>
                <input type="text" name="role" id="role" value="Student" readonly disabled>
            </div>

            <div>
                <label for="gender">Spol: </label>
                <input type="radio" name="gender"> Muški
                <input type="radio" name="gender"> Ženski
            </div>

            <div>
                <button type="submit">Spremi promjene</button>
            </div>
        </form>
    </div>
    <div>
        <form action="#">
            <div>
                <h3>Lozinka</h3>
            </div>
            <div>
                <label for="password">Trenutna lozinka: </label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <label for="password_new">Nova lozinka: </label>
                <input type="password" name="password_new" id="password_new">
            </div>

            <div>
                <label for="password_confirm">Potvrdi novu lozinku: </label>
                <input type="password" name="password_confirm" id="password_confirm">
            </div>
            <div>
                <button type="submit">Ažuriraj lozinku</button>
            </div>
        </form>
    </div>
</div>
