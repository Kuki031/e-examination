<x-header />


<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2 style="text-align: center">Dostupne provjere znanja</h2>
        </div>

        @if (sizeof($exams) > 0)
        <table class="table-main">
            <thead>
                <tr>
                    <th>Naziv</th>
                    <th>Otvoreno?</th>
                    <th>Akcije</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($exams as $exam)
                    <tr>
                        <td data-label="Naziv">{{ $exam->name }}</td>
                        <td data-label="Otvoreno?">{{ $exam->in_process_formatted }}</td>
                        <td data-label="Akcije">
                            <div class="table-options">
                                @if (!auth()->user()->is_in_exam)
                                        <form action="{{ route('exams.confirmation', $exam) }}">
                                            <button class="table-options-btn details" type="submit">Pristupi</button>
                                        </form>
                                    @elseif (auth()->user()->is_in_exam && auth()->user()->last_accessed_exam === $exam->id)

                                    @php
                                        $examAttempt = \App\Models\ExamAttempt::where("user_id", "=", auth()->user()->id)
                                        ->where("exam_id", "=", $exam->id)
                                        ->latest()
                                        ->first();
                                    @endphp
                                    <form action="{{ route('exams.load_exam', [$examAttempt, $exam]) }}">
                                        <button
                                        style="{{ $examAttempt->status === 'in_process' ? 'background-color: #1F2A44;' : '' }}"
                                        class="table-options-btn details" type="submit">{{ $examAttempt->status === 'in_process' ? 'U tijeku🕓' : 'Pristupi' }}</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $exams->links('vendor.pagination.simple-next-prev') }}
        </div>
        @else
            <div style="display: flex;align-items:center;justfy-content:center;margin:auto;">
                <h1 style="color: #1F2A44; margin: 1rem auto;">Nema dostupnih provjeri znanja. Pokušajte osvježiti stranicu!</h1>
            </div>
        @endif
    </div>
</div>

