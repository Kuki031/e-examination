<x-header />

<div class="question-details-main">
    <div class="question-details-wrap">
        <div class="question-details-content">
            <input class="exam-id" type="hidden" readonly disabled value="{{ $exam->id }}">
            <form class="question-details-content-form" action="{{ route('teacher.exam_question_update', [$exam, $question]) }}" method="POST">
                @csrf
                @method("PATCH")
                <div>
                    <p><b>Provjera znanja: {{ $exam->name }}</b></p>
                    <p><b>ID pitanja: <span class="question-id">{{ $question->id }}</span></b></p>
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
                <p><b>Broj odgovora: <span class="number-of-answers">{{ sizeof($question->answers) - 1 }}</span></b></p>
                <p><b>Odgovori: </b></p>
                <div>
                    <button class="new-answer">Novi odgovor</button>
                </div>
                @php
                    $correctAnswer = $question->answers['is_correct'];
                @endphp

                <div class="answers-holder">
                    @php
                        $answersLength = str_split($question->answers[1]);
                    @endphp
                    <input class="answers-length" type="hidden" disabled readonly value="{{ sizeof($answersLength) }}">
                    @foreach ($question->answers as $key => $answer)

                        @if ($key === 'is_correct')
                            @continue
                        @endif

                        @php
                            $isCorrect = $answer === $correctAnswer;
                        @endphp
                        <div class="answer-actions">
                            <textarea @if ($isCorrect)
                                style="background: #aff3ce;"
                            @endif class="question-details-input answer {{ $isCorrect ? 'correct' : '' }}" cols="{{ sizeof($answersLength) }}" spellcheck="false">{{ $answer }}</textarea>
                            <div>
                                <button class="answer-action-delete">Obriši</button>
                                <div class="is-correct-div">
                                    <input type="radio" name="is_correct" {{ $isCorrect ? 'checked' : '' }}>
                                    <span>Točan</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div>
                    <button class="update-answers">Ažuriraj odgovore</button>
                </div>
            </div>
        </div>
    </div>
</div>
