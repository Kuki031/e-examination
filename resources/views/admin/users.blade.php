<x-header />


<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2>Korisnici</h2>
        </div>

        <div class="table-title">
            <x-search-bar :search="'korisnike'" />
            @if(request('search'))
                <a href="{{ route('admin.new_users_list') }}" class="reset-filter-link">
                    Poništi pretragu
                </a>
            @endif
        </div>

        <table class="table-main">
            <thead>
                <tr>
                    <th>E-mail</th>
                    <th>Vrsta ID-a</th>
                    <th>Vrijednost ID-a</th>
                    <th>Prezime i ime</th>
                    <th>Vrsta registracije</th>
                    <th>Odobren?</th>
                    <th>Akcije</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    @if ($user->pin_value === auth()->user()->pin_value)
                        @continue
                    @endif
                    <tr>
                        <td data-label="E-mail">{{ $user->email }}</td>
                        <td data-label="Vrsta ID-a">{{ $user->pin }}</td>
                        <td data-label="Vrijednost ID-a">{{ $user->pin_value }}</td>
                        <td data-label="Prezime i ime">{{ $user->full_name_formatted }}</td>
                        <td data-label="Vrsta registracije">{{ $user->registration_type_formatted }}</td>
                        <td data-label="Odobren?">{{ $user->is_allowed ? "✔️" : "❌" }}</td>
                        <td data-label="Akcije">
                            <div class="table-options">
                                @if ($user->is_in_pending_status)
                                    <form action="{{ route('admin.approve_registration', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="table-options-btn positive">Odobri</button>
                                    </form>
                                    <form action="{{ route('admin.reject_registration', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="table-options-btn negative">Odbij</button>
                                    </form>

                                @elseif (!$user->is_in_pending_status && $user->is_allowed)
                                    <form action="{{ route('admin.reject_registration', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="table-options-btn negative">Odbij</button>
                                    </form>
                                @elseif (!$user->is_in_pending_status && !$user->is_allowed)
                                    <form action="{{ route('admin.approve_registration', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="table-options-btn positive">Odobri</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.user_profile', $user) }}">
                                    <button class="table-options-btn details" type="submit">Profil</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $users->links('vendor.pagination.simple-next-prev') }}
        </div>
    </div>
</div>

