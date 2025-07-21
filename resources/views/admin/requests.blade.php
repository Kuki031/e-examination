<x-header />


@if (isset($unconfirmedUsers) && sizeof($unconfirmedUsers) > 0)

<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2>Zahtjevi za registraciju</h2>
        </div>
        <table class="table-main">
            <thead>
                <tr>
                    <th>E-mail</th>
                    <th>Vrsta ID-a</th>
                    <th>Vrijednost ID-a</th>
                    <th>Prezime i ime</th>
                    <th>Vrsta registracije</th>
                    <th>Akcije</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($unconfirmedUsers as $user)
                    <tr>
                        <td data-label="E-mail">{{ $user->email }}</td>
                        <td data-label="Vrsta ID-a">{{ $user->pin }}</td>
                        <td data-label="Vrijednost ID-a">{{ $user->pin_value }}</td>
                        <td data-label="Prezime i ime">{{ $user->full_name_formatted }}</td>
                        <td data-label="Vrsta registracije">{{ $user->registration_type_formatted }}</td>
                        <td data-label="Akcije">
                            <div class="table-options">
                                <form action="{{ route('admin.approve_registration', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="table-options-btn positive">Odobri</button>
                                </form>
                                <form action="{{ route('admin.reject_registration', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="table-options-btn negative">Odbij</button>
                                </form>
                                <button class="table-options-btn details">Detalji</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $unconfirmedUsers->links('vendor.pagination.simple-next-prev') }}
        </div>
    </div>
</div>
@else
    <div class="table-title-fallback">
        <h2>Trenutno nema zahtjeva za registraciju u aplikaciju!</h2>
    </div>
@endif
