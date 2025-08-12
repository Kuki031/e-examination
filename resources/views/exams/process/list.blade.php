<x-header />


<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2>Dostupne provjere znanja</h2>
        </div>

        <div class="table-title">
            <x-search-bar :search="'provjere znanja'" />
            @if(request('search'))
                <a href="{{ route('exams.list') }}" class="reset-filter-link">
                    Poništi pretragu
                </a>
            @endif
        </div>

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
                                        $examAttempt = \App\Models\ExamAttempt::where("user_id", "=", auth()->user()->id)->where("exam_id", "=", $exam->id)->first();
                                    @endphp
                                    <form action="{{ route('exams.load_exam', [$examAttempt, $exam]) }}">
                                        <button class="table-options-btn details" type="submit">Pristupi</button>
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
    </div>
</div>

