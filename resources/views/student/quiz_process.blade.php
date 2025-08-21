<x-header />

@php
    $questions = $examAttempt->questions;
@endphp


<span id="attempt_id" hidden>{{ $examAttempt->id }}</span>
<span id="load_process_script" hidden>1</span>
<span id="exam_id" hidden>{{ $examAttempt->exam_id }}</span>
<span id="user_id" hidden>{{ auth()->id() }}</span>

<div class="exam-process-main">
    <div class="exam-header">
        <h1>{{ $examAttempt->exam->name }}</h1>
    </div>
  <div class="exam-process-wrap">
    <div class="exam-process-section question-section" style="display: none;">
      <div class="question-timer">
        @foreach ($questions as $index => $question)

            <div class="question-wrap" data-question="{{ $index + 1 }}" style="display: none;">
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
                            <input id="{{ $inputId }}" class="answer q{{ $index + 1 }}a{{ $j }}" type="radio" name="answer{{ $index + 1 }}">
                            {{ $answer }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
