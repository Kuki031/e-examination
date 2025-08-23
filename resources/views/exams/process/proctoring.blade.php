<x-header />

<span id="exam_id" hidden>{{ $exam->id }}</span>
<span id="start_proctoring" hidden></span>

<div class="proctor-main">
    <div>
        <div class="proctor-options">
        <div class="proctor-option">
            <input id="search_student" type="text" placeholder="Pretraži studenta" spellcheck="false" autocomplete="off">
        </div>
        <div class="proctor-option">
            <div>
                <input type="text" id="notification" placeholder="Unesite notifikaciju" spellcheck="false" autocomplete="off">
                <button class="action-button success notify">Pošalji notifikaciju</button>
            </div>
            <div class="proctor-option">
                <form action="{{ route('teacher.stop_exam', $exam) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="action-button danger">
                        Zaustavi provjeru znanja
                    </button>
                </form>
            </div>
        </div>
        <div class="proctor-option">
            <p class="exam-code-input exam-code-input-input" style="font-size: 1.5rem;">Pristupni kod: <span>{{ $exam->access_code_formatted }}</span></p>
            </div>
        </div>
    </div>
    <div class="proctor-header">
        <h1>Prisutni studenti</h1>
        <p>Broj spojenih studenata: <span id="student_counter">0</span></p>
    </div>
    <div class="proctor-wrap">

    </div>
</div>
