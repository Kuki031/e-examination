<x-header />

@php
    $questions = $examAttempt->questions;
    $state = json_decode($examAttempt?->state);
    $checkedAnswers = $state?->checked_answers;
    $currentQuestion = $state?->current_question;
    $navBtns = $state?->nav_btns;

@endphp
<span id="attempt_id" hidden>{{ $examAttempt->id }}</span>
<span id="current_question" hidden>{{ $currentQuestion }}</span>
<span id="load_script" hidden>1</span>
<span id="exam_id" hidden>{{ $examAttempt->exam_id }}</span>
<span id="activity_log" hidden></span>

<div class="exam-process-main">
    <div class="exam-header">
        <h1>{{ $examAttempt->exam->name }}</h1>
    </div>
  <div class="exam-process-wrap">
    <div class="exam-process-section nav-section">
      <div class="exam-process-section-nav">
        @for ($i = 1; $i <= count($questions); $i++)
            @php
                $isChecked = $navBtns && in_array($i, $navBtns);
            @endphp
            <button
                style="{{ $isChecked ? 'background-color: #3ea87f' : '' }}"
                class="exam-process-nav-btn {{ $isChecked ? 'checked' : '' }}">
                {{ $i }}
            </button>
        @endfor
      </div>
    </div>

    <div class="exam-process-section question-section">
      <div class="question-timer">
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
                        @if ($key === 'is_correct')
                            @continue
                        @endif
                        @php $j++; $inputId = "q{$index}_a{$j}"; @endphp
                        <label for="{{ $inputId }}">
                            <input id="{{ $inputId }}" class="answer q{{ $index + 1 }}a{{ $j }}" type="radio" name="answer{{ $index + 1 }}" @if ($checkedAnswers)
                                {{ in_array($inputId, $checkedAnswers) ? 'checked' : '' }}
                            @endif />
                            {{ $answer }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="timer" data-time="{{ $timeToSolve->time_to_solve }}" data-started-at="{{ $examAttempt->started_at->timestamp }}">
            <span id="countdown">--:--</span>
        </div>
      </div>

      <div class="navigation-buttons">
        <button class="nav-btn">Prethodno pitanje</button>
        <button class="nav-btn">Sljedeće pitanje</button>
      </div>
    </div>
  </div>
</div>

<x-spa-modal :subtitle="'Želite li predati ispit?'" />
