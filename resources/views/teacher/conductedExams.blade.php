<x-header />

<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2>Provedene provjere znanja</h2>
        </div>

        @if (sizeof($conductedExams) > 0)

        <div class="table-title">
            <x-search-bar :search="'provedene provjere znanja'" />
            @if(request('search'))
                <a href="{{ route('teacher.conducted_exams') }}" class="reset-filter-link">
                    Poništi pretragu
                </a>
            @endif
        </div>

        <table class="table-main">
            <thead>
                <tr>
                    <th>ID ispita</th>
                    <th>Naziv</th>
                    <th>Broj sudionika</th>
                    <th>Početak</th>
                    <th>Kraj</th>
                    <th>Akcije</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($conductedExams as $conductedExam)
                    <tr>
                        <td data-label="ID ispita">{{ $conductedExam->exam->id }}</td>
                        <td data-label="Naziv">{{ $conductedExam->exam->name}}</td>
                        <td data-label="Broj sudionika">{{ $conductedExam->num_of_participants }}</td>
                        <td data-label="Početak">{{ $conductedExam->start_time_formatted }}</td>
                        <td data-label="Kraj">{{ $conductedExam->end_time_formatted }}</td>
                        <td data-label="Akcije">
                            <div class="table-options">
                                <form action="{{ route('teacher.conducted_exams_details', [$conductedExam, $conductedExam->exam]) }}" method="GET">
                                    <button
                                    style="{{ $conductedExam->exam->in_process ? 'background-color: #1F2A44' : '' }}"
                                     class="table-options-btn details" type="submit">{{ $conductedExam->exam->in_process ? 'U tijeku' : 'Detalji' }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $conductedExams->links('vendor.pagination.simple-next-prev') }}
        </div>
    </div>
    @else
        <div>
            <h1 style="color: #1F2A44; margin-top: 1rem;">Nema provedenih provjeri znanja!</h1>
        </div>
    @endif
</div>

