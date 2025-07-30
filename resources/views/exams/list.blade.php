<x-header />


<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2>Provjere znanja</h2>
        </div>

        <div class="table-title">
            <x-search-bar :search="'provjere znanja'" />
            @if(request('search'))
                <a href="{{ route('teacher.teacher_exams') }}" class="reset-filter-link">
                    Poništi pretragu
                </a>
            @endif
        </div>

        <table class="table-main">
            <thead>
                <tr>
                    <th>Naziv</th>
                    <th>Kreirano</th>
                    <th>Ažurirano</th>
                    <th>Akcije</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($exams as $exam)
                    <tr>
                        <td data-label="Naziv">{{ $exam->name }}</td>
                        <td data-label="Kreirano">{{ $exam->created_at_formatted }}</td>
                        <td data-label="Ažurirano">{{ $exam->updated_at_formatted }}</td>
                        <td data-label="Akcije">
                            <div class="table-options">
                                <form action="{{ route('teacher.exam_details', $exam) }}">
                                    <button class="table-options-btn details" type="submit">Detalji</button>
                                </form>
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

