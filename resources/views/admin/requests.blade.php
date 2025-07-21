<x-header />

<div class="tables-main">
    <div class="table-wrap">
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
                @foreach ($unconfirmedUsers as $user)
                    <tr>
                        <td data-label="E-mail">{{ $user->email }}</td>
                        <td data-label="Vrsta ID-a">{{ $user->pin }}</td>
                        <td data-label="Vrijednost ID-a">{{ $user->pin_value }}</td>
                        <td data-label="Prezime i ime">{{ $user->full_name_formatted }}</td>
                        <td data-label="Vrsta registracije">{{ $user->registration_type_formatted }}</td>
                        <td data-label="Odobren?">{{ $user->is_allowed_formatted }}</td>
                        <td data-label="Akcije">
                            <x-table-actions :success="'Odobri'" :failure="'Odbij'" :details="'Detalji'" />
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
