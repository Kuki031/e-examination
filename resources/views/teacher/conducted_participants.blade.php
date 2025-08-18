<x-header />


<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2>Sudionici</h2>
        </div>

        <table class="table-main">
            <thead>
                <tr>
                    <th>ID pokušaja</th>
                    <th>Prezime i ime</th>
                    <th>JMBAG</th>
                    <th>Početak</th>
                    <th>Kraj</th>
                    <th>Položio?</th>
                    <th>IP adresa</th>
                    <th>Napomena</th>
                    <th>Akcije</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($attempts as $attempt)
                    <tr>
                        <td data-label="ID pokušaja">{{ $attempt->id }}</td>
                        <td data-label="Prezime i ime">{{ $attempt->user->full_name_formatted }}</td>
                        <td data-label="JMBAG">{{ $attempt->user->pin_value }}</td>
                        <td data-label="Početak">{{ $attempt->started_at_formatted }}</td>
                        <td data-label="Kraj">{{ $attempt->ended_at_formatted }}</td>
                        <td data-label="Položio?">{{ $attempt->has_passed ? "✔️" : "❌" }}</td>
                        <td data-label="IP adresa">{{ $attempt->ip_address }}</td>
                        <td data-label="Napomena">{{ $attempt->note }}</td>
                        <td data-label="Akcije">
                            <div class="table-options">
                                <form action="{{ route('teacher.user_profile', $attempt->user) }}">
                                    <button class="table-options-btn details" type="submit">Profil</button>
                                </form>
                                <form action="{{ route('teacher.conducted_exam_activites', [$attempt->exam, $attempt->user]) }}">
                                    <button class="table-options-btn details" type="submit">Zapisi</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $attempts->links('vendor.pagination.simple-next-prev') }}
        </div>
    </div>
</div>

