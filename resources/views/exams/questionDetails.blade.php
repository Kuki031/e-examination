<x-header />

<div class="question-details-main">
    <div class="question-details-wrap">
        <div class="question-details-content">
            <form class="question-details-content-form" action="{{ route('teacher.exam_question_update', [$exam, $question]) }}" method="POST">
                @csrf
                @method("PATCH")
                <div>
                    <p><b>Provjera znanja: {{ $exam->name }}</b></p>
                    <p><b>ID pitanja: {{ $question->id }}</b></p>
                </div>

                <div>
                    <label for="question">Pitanje: </label>
                    <textarea cols="50" rows="20" name="question" id="question" spellcheck="false">{{ $question->question }}</textarea>
                </div>
                <div>
                    <label for="created_at_formatted">Kreirano: </label>
                    <input class="question-details-input" type="text" name="created_at" value="{{ $question->created_at_formatted }}" disabled>
                </div>

                <div>
                    <label for="updated_at_formatted">Ažurirano: </label>
                    <input class="question-details-input" type="text" name="updated_at" value="{{ $question->updated_at_formatted }}" disabled>
                </div>
            </form>

            <div>
                <button class="form-action-update-question">Ažuriraj pitanje</button>
                <x-modal-action :text="'Obriši pitanje'" class="strict-confirmation-btn-admin" />
                <x-generic-modal :confirmAction="route('teacher.exam_question_delete', [$exam, $question])" subtitle="Ova radnja će trajno obrisati pitanje s ID-em {{ $question->id }}." :method="'DELETE'" />
            </div>
        </div>

        <div class="question-details-content">
            <div class="answer-wrap">
                <p><b>Broj odgovora: {{ sizeof($question->answers) - 1 }}</b></p>
                <p><b>Odgovori: </b></p>

                @php
                    $correctAnswer = $question->answers['is_correct'];
                @endphp

                @foreach ($question->answers as $key => $answer)

                    @if ($key === 'is_correct')
                        @continue
                    @endif

                    @php
                        $answersLength = str_split($answer);
                        $isCorrect = $answer === $correctAnswer;
                    @endphp
                    <div class="answer-actions">
                        <textarea @if ($isCorrect)
                            style="background: #aff3ce;"
                        @endif class="question-details-input answer" cols="{{ sizeof($answersLength) }}" spellcheck="false">{{ $answer }}</textarea>
                        <div>
                            <button class="answer-action-delete">Obriši</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
