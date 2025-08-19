<x-header />


<div class="tables-main">
    <div class="table-wrap">
        <div class="table-title">
            <h2 style="text-align: center">Provjere znanja</h2>
        </div>

        @if (sizeof($exams) > 0)

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
                                    <button
                                    style="{{ $exam->in_process ? 'background-color: #1F2A44' : '' }}"
                                     class="table-options-btn details" type="submit">{{ $exam->in_process ? 'U tijeku🕓' : 'Detalji' }}</button>
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
        @else
            <div style="display: flex;align-items:center;justify-content:center;margin:auto;">
                <h1 style="color: #1F2A44; margin-top: 1rem;">Nemate kreiranih provjeri znanja!</h1>
            </div>
        @endif
    </div>
</div>

