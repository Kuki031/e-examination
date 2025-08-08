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
                                <form action="{{ route('exams.confirmation', $exam) }}">
                                    <button class="table-options-btn details" type="submit">Pristupi</button>
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

