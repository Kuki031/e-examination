<x-header />

<div style="
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        margin: auto 20px;
        align-items: center;
        justify-content: center;
      ">
      <div>
        <h1>Kreiranje pitanja za provjeru znanja: Ispit2AB (min. 5 pitanja)</h1>
      </div>
      <div
        id="exam_options"
        style="
          display: flex;
          flex-wrap: wrap;
          flex-direction: row;
          gap: 10px;
          margin: 10px;
        ">
        <button class="add_question">Dodaj pitanje +</button>
        <button style="display: none" class="save_exam">Spremi ispit</button>
      </div>

      <div style="
          display: flex;
          flex-direction: column;
          gap: 10px;
          margin: auto 20px;
        "
        id="questions"></div>
    </div>
