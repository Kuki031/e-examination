<x-header />

@php
    use Illuminate\Support\Str;
@endphp

<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2>Pitanja za provjeru znanja: {{ $exam->name }}</h2>
        </div>

        <div class="table-title">
            <div>
                <x-search-bar :search="'pitanja'" />
            </div>
            <div>
                <a class="question-creator" href="{{ route('teacher.create_questions', $exam) }}">Kreator pitanja ✨</a>
            </div>
            @if(request('search'))
                <div>
                    <a href="{{ route('teacher.exam_question_list', $exam) }}" class="reset-filter-link">
                    Poništi pretragu
                </a>
                </div>
            @endif
        </div>

        <table class="table-main">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pitanje</th>
                    <th>Broj odgovora</th>
                    <th>Kreirano</th>
                    <th>Ažurirano</th>
                    <th>Akcije</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td data-label="ID">{{ $question->id }}</td>
                        <td data-label="Pitanje">{{ Str::words($question->question, 15, '...') }}</td>
                        <td data-label="Broj odgovora">{{ sizeof($question->answers) - 1 }}</td>
                        <td data-label="Kreirano">{{ $question->created_at_formatted }}</td>
                        <td data-label="Ažurirano">{{ $question->updated_at_formatted }}</td>
                        <td data-label="Akcije">
                            <div class="table-options">
                                <form action="{{ route('teacher.exam_question_details', [$exam, $question]) }}" method="GET">
                                    <button class="table-options-btn details" type="submit">Detalji</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $questions->links('vendor.pagination.simple-next-prev') }}
        </div>
    </div>
</div>

