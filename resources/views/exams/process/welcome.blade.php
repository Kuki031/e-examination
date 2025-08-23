<x-header />

<div class="exam-welcome-main">
    <div class="exam-welcome-wrap">

        <div class="exam-welcome-header">
            <h2>{{ $exam->name }}</h2>
        </div>

        <div class="exam-information-main">
            <div>
                <p><b>Nastavnik: {{ $exam->user->full_name }}</b></p>
            </div>

            <div>
                <p class="exam-p"><b>Informacije o ispitu: </b></p>
                @if ($exam->description)
                    @php
                        $decsSplit = explode("\n", $exam->description);
                    @endphp
                    @foreach ($decsSplit as $dec)
                        <p class="exam-p">{{ $dec }}</p>
                    @endforeach
                @else
                    <p>Nema dodatnih informacija.</p>
                @endif
            </div>
        </div>

        <div class="exam-options">
            <div>
                <label for="access_code"><b>Pristupni kod: </b></label>
                <form action="{{ route('exams.join_exam', $exam) }}" method="POST">
                    @csrf
                    <input class="access_code_student" type="text" name="access_code" id="access_code"
                           autocomplete="off" autocapitalize="off" required>
                    <button class="access-btn">Pristupi</button>
                </form>
            </div>
        </div>

    </div>
</div>
