<x-header />

<span id="exam_id" hidden>{{ $exam->id }}</span>
<span id="current_question" hidden>1</span>
<span id="quiz_started" hidden>{{ $exam->is_quiz_in_progress }}</span>
<span id="user_role" hidden>{{ $exam->user->role }}</span>

@php
    $numOfQuestions = sizeof($questions);
    $currentQuestions = 0;
@endphp

<div class="proctor-main">
    <div>
        <div class="proctor-options">

        <div class="proctor-option">
            <p class="exam-code-input exam-code-input-input" style="font-size: 1.5rem;">Pristupni kod: <span>{{ $exam->access_code_formatted }}</span></p>
        </div>
            <p class="exam-code-input exam-code-input-input" style="font-size: 1.5rem; color:green;">Broj spojenih studenata: <span id="connected_students">0</span></p>
            <div>
                <button id="start_quiz" style="background-color:green;cursor: pointer;color:#fff">Započni kviz</button>
            </div>
            <div class="proctor-option">
                <form action="{{ route('teacher.stop_exam', $exam) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="action-button danger stop-quiz">
                        Zaustavi kviz
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="proctor-wrap" style="align-items:center;justify-content:center;background-color:#fff;box-shadow:none; display: none;">
        <div class="question-timer" style="background-color:#fff">
        @foreach ($questions as $index => $question)

            <div class="question-wrap" data-question="{{ $index + 1 }}" style="{{ $index > 0 ? 'display:none' : '' }}">
                <p class="question-text q{{ $index + 1 }}">
                    {{ $index + 1 }}. {{ $question['question'] }}
                </p>

                @if (!empty($question['image']))
                    <div class="question-image">
                        <img src="{{ asset('storage/' . $question['image']) }}" />
                    </div>
                @endif
                <div class="answers-wrap">
                    @php $j = 0; @endphp
                    @foreach ($question['answers'] as $key => $answer)
                    @php
                    $j++;
                    @endphp
                        @if ($key === 'is_correct')
                            @continue
                        @endif
                        <p style="font-size: 2rem;">{{ $j }}. {{ $answer }}</p>
                    @endforeach
                </div>
        </div>
        @endforeach
      </div>
    </div>
        <div class="navigation-buttons" style="display: none;">
            <button id="prev-btn" class="nav-btn">Prethodno pitanje</button>
            <button id="next-btn" class="nav-btn">Sljedeće pitanje</button>
        </div>
</div>

