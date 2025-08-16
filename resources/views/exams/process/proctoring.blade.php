<x-header />

<span id="exam_id" hidden>{{ $exam->id }}</span>
<span id="start_proctoring" hidden></span>

<div class="proctor-main">
    <div>
        <div class="proctor-options">
        <div class="proctor-option">
            <input type="text" placeholder="Pretraži studenta" spellcheck="false" autocomplete="off">
        </div>
        <div class="proctor-option">
            <div>
                <input type="text" id="notification" placeholder="Unesite notifikaciju" spellcheck="false" autocomplete="off">
                <button class="action-button success notify">Pošalji notifikaciju</button>
            </div>
        </div>
        </div>
    </div>
    <div class="proctor-header">
        <h1>Prisutni studenti</h1>
    </div>
    <div class="proctor-wrap">

    </div>
</div>
