<x-header />

<div class="question-main">
    <div class="question-wrap">
    <div class="question-title">
        <h1>{{ $exam->name }} (min. 5 pitanja)</h1>
        <span id="exam-id" hidden>{{ $exam->id }}</span>
    </div>
        <div>
        <div id="exam_options" class="question-options">
            <button class="add_question">Dodaj pitanje +</button>
            <button style="display: none" class="save_exam">Spremi ispit</button>
        </div>
        </div>
      <div class="questions-holder" id="questions"></div>
    </div>
</div>
