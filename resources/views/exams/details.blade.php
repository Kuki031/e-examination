<x-header />

<div class="exam-form-main">
    <div class="exam-form-wrap">

        <div class="exam-form-section">
            <div class="exam-form-content">
                <span class="exam_id" hidden>{{ $exam->id }}</span>
                <h4>Opće informacije</h4>

                <form action="{{ route('teacher.update_exam', $exam) }}" method="POST">
                    @csrf
                    @method("PATCH")

                    <div class="exam-form-form-wrap">
                        <div>
                            <label for="required_for_pass">Potrebno za prolaz: </label>
                            <input type="text" name="required_for_pass" id="required_for_pass" value="{{ $exam->required_for_pass ? $exam->required_for_pass : 0 }}" {{ !$exam->num_of_questions ? 'disabled' : '' }} autocomplete="off">
                        </div>
                    </div>
                    @error("required_for_pass")
                        <div class="error-div">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    @include('exams._form')

                    <div class="exam-form-form-wrap">
                        <button type="submit">Spremi promjene</button>
                    </div>
                </form>

                <x-modal-action :text="'Obriši provjeru znanja'" class="strict-confirmation-btn-admin" />
                <x-generic-modal
                    :confirmAction="route('teacher.delete_exam', $exam)"
                    subtitle="Ova radnja će trajno obrisati provjeru znanja {{ $exam->id }}."
                    :method="'DELETE'"
                />
            </div>
        </div>

        <div class="exam-form-section">
            <div class="exam-form-content">
                <h4>Detalji provjere znanja: {{ $exam?->name }}</h4>

                @foreach ([
                    ['num_of_questions', 'Broj pitanja', $exam?->num_of_questions ?? 'Nema pitanja'],
                    ['num_of_points', 'Ukupan broj bodova', $exam?->num_of_points ?? 'Nedefinirano'],
                    ['in_process', 'U procesu', $exam?->in_process ? 'Da' : 'Ne'],
                    ['start_time', 'Početak', $exam?->start_time ?? 'Nedefinirano'],
                    ['end_time', 'Kraj', $exam?->end_time ?? 'Nedefinirano'],
                    ['created_at', 'Kreirano', $exam?->created_at_formatted],
                    ['updated_at', 'Ažurirano', $exam?->updated_at_formatted],
                ] as [$field, $label, $value])
                    <div class="exam-form-form-wrap">
                        <div>
                            <label for="{{ $field }}">{{ $label }}:</label>
                            <input
                                type="text"
                                name="{{ $field }}"
                                id="{{ $field }}"
                                value="{{ $value }}"
                                disabled
                            >
                        </div>
                    </div>
                    @error($field)
                        <div class="error-div"><span>{{ $message }}</span></div>
                    @enderror
                @endforeach
            </div>

            <div class="exam-form-content">
                <h4>Pristupni kod</h4>
                <div class="exam-code">
                    <input
                        class="exam-code-input exam-code-input-input"
                        type="text"
                        name="security_code"
                        autocomplete="off"
                        value="{{ $exam->access_code_formatted }}"
                        disabled
                    >
                    <button class="exam-code-input exam-code-input-button">
                        Generiraj pristupni kod
                    </button>
                    @if (!$exam->in_process)
                        <form action="{{ route('teacher.start_exam', $exam) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="action-button {{ !$exam?->num_of_questions ? 'danger' : 'success' }}"
                            {{ !$exam?->num_of_questions ? 'disabled' : '' }}>
                            Pokreni provjeru znanja
                        </button>
                    </form>
                    @else
                    <form action="{{ route('teacher.stop_exam', $exam) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="action-button danger">
                            Zaustavi provjeru znanja
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="exam-form-section">
            <div class="exam-form-content">
                <h4>Pitanja</h4>
                <div class="exam-form-form-wrap">
                    <a class="exam-details-btn" href="{{ route('teacher.exam_question_list', $exam) }}">Pregled pitanja</a>
                    <a class="exam-details-btn" href="{{ route('teacher.create_questions', $exam) }}">Kreator pitanja ✨</a>
                </div>
            </div>

            <div class="exam-form-content">
                <h4>Gamifikacija (kviz)</h4>
                <div class="exam-form-form-wrap">
                    <a class="exam-details-btn" href="#">Podijeli 🎮</a>
                </div>
            </div>
        </div>

    </div>
</div>
