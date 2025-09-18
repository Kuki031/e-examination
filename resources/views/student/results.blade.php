<x-header />

<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <div>
                <h2 style="text-align: center">Rezultati</h2>
            </div>
        </div>

        @if (sizeof($examAttempts) > 0)
        <table class="table-main">
            <thead>
                <tr>
                    <th>Ispit</th>
                    <th>Započeto</th>
                    <th>Završeno</th>
                    <th>Ostvareno bodova</th>
                    <th>Položeno?</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($examAttempts as $attempt)
                    <tr>
                        <td data-label="Ispit">{{ $attempt?->exam->name }}</td>
                        <td data-label="Započeto">{{ $attempt->started_at_formatted }}</td>
                        <td data-label="Završeno">{{ !$attempt->ended_at_formatted ? 'U tijeku' : $attempt->ended_at_formatted }}</td>
                        <td data-label="Ostvareno bodova">{{ $attempt->score }} / {{ $attempt->total_points }} ({{ round(($attempt->score / $attempt->total_points) * 100, 2) }}%)</td>
                        <td data-label="Položeno?">{{ $attempt->has_passed ? '✔️' : '❌' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $examAttempts->links('vendor.pagination.simple-next-prev') }}
        </div>
        @else
            <div style="display: flex;align-items:center;justify-content:center;margin:auto;">
                <h1 style="color: #1F2A44; margin-top: 1rem;">Nema dostupnih rezultata!</h1>
            </div>
        @endif
    </div>
</div>

