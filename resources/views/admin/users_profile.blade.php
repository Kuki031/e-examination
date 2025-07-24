<x-header />


<div class="profile-main">
    <div class="profile-wrap">
        <div class="profile-title">
            <h2>Informacije o korisniku #{{ $user->id }}</h2>
        </div>

        <div class="profile-section-wrap">
            <div class="profile-section">
                <div class="profile-subsection">

                    <div class="profile-section-input">
                        <div
                            class="profile-picture"
                            style="background-image: url('{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/auth_module/user_placeholder.png') }}');">
                        </div>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="email">E-mail adresa: </label>
                        <span class="status">{{ $user->email }}</span>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="full_name">Prezime i ime: </label>
                        <span class="status">{{ $user->full_name_formatted }}</span>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="pin_value">{{ $user->pin }}: </label>
                        <span class="status">{{ $user->pin_value }}</span>
                    </div>
                </div>

                <div class="profile-subsection">
                    <div class="profile-section-input">
                        <label class="profile-label" for="role">Uloga: </label>
                    <span class="status">{{ $user->role_formatted }}</span>
                    </div>
                        <div class="profile-section-input">
                        <form action="{{ route('admin.assign_role', $user) }}" method="POST">
                            @csrf
                            @method("PATCH")
                            <select class="admin-select-role" name="role" id="role">
                                <option value="">Odaberite ulogu</option>
                                <option value="teacher">Nastavnik</option>
                            </select>
                                <button class="admin-profile-action" type="submit">Dodjeli ulogu</button>
                        </form>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="gender">Spol: </label>
                        <span class="status">{{ $user->gender_formatted }}</span>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="status">Status: </label>
                        <span class="status">{{ $user->status_formatted }}</span>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="status">Vrsta registracije: </label>
                        <span class="status">{{ $user->registration_type_formatted }}</span>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="status">Odobren: </label>
                        <span class="status">{{ $user->is_allowed ? "✔️" : "❌" }}</span>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="status">U statusu odobravanja? </label>
                        <span class="status">{{ $user->is_in_pending_status_formatted }}</span>
                    </div>
                    <div class="profile-section-input">
                        <label class="profile-label" for="status">Registriran/a:  </label>
                        <span class="status">{{ $user->created_at_formatted }}</span>
                    </div>

                    <div class="profile-section-input">
                        <label class="profile-label" for="status">Zadnje ažuriranje profila:  </label>
                        <span class="status">{{ $user->updated_at_formatted }}</span>
                    </div>

                    <div class="profile-section-input">
                        <x-modal-action :text="'Obriši korisnika'" class="strict-confirmation-btn-admin" />
                        <x-generic-modal
                            :confirmAction="route('admin.delete_user', $user)"
                            subtitle="Ova radnja će trajno obrisati korisnika {{ $user->full_name }}."
                            :method="'DELETE'"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
