<x-header />

<div class="exam-form-main">
    <div class="exam-form-wrap">
        <div>
            <div class="exam-form-content">
                <h4>Opće informacije</h4>
                <form action="{{ route('teacher.update_exam', $exam) }}" method="POST">
                @csrf
                @method("PATCH")
                @include('exams._form')
            </div>
        </div>
        <div class="exam-form-content">
            <h4>Detalji provjere znanja: {{ $exam?->name }}</h4>
            <div class="exam-form-form-wrap">
                <div>
                    <label for="num_of_questions">Broj pitanja: </label>
                    <input type="text" name="num_of_questions" id="num_of_questions" autocomplete="off" value="{{ $exam?->num_of_questions ?? 'Nema pitanja' }}" disabled>
                </div>
            </div>
                @error('num_of_questions')
                    <div class="error-div">
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            <div class="exam-form-form-wrap">
                <div>
                    <label for="num_of_points">Ukupan broj bodova: </label>
                    <input type="text" name="num_of_points" id="num_of_points" value="{{ $exam?->num_of_points ?? 'Nedefinirano' }}" disabled>
                </div>
            </div>
                @error('num_of_points')
                    <div class="error-div">
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            <div class="exam-form-form-wrap">
                <div>
                    <label for="required_for_pass">Potrebno za prolaz: </label>
                    <input type="number" name="required_for_pass" id="required_for_pass" value="{{ $exam?->required_for_pass ?? 'Nedefinirano' }}" {{ !$exam?->num_of_questions ? 'disabled' : '' }}>
                </div>
            </div>
                @error('required_for_pass')
                    <div class="error-div">
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            <div class="exam-form-form-wrap">
                <div>
                    <label for="in_process">U procesu: </label>
                    <input type="text" name="in_process" id="in_process" value="{{ $exam?->in_process ? 'Da' : 'Ne' }}" disabled>
                </div>
            </div>
                @error('in_process')
                    <div class="error-div">
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            <div class="exam-form-form-wrap">
                <div>
                    <label for="start_time">Početak: </label>
                    <input type="text" name="start_time" id="start_time" value="{{ $exam?->start_time ?? 'Nedefinirano' }}" disabled>
                </div>
            </div>
                @error('start_time')
                    <div class="error-div">
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            <div class="exam-form-form-wrap">
                <div>
                    <label for="end_time">Kraj: </label>
                    <input type="text" name="end_time" id="end_time" value="{{ $exam?->end_time ?? 'Nedefinirano' }}" disabled>
                </div>
            </div>
                @error('end_time')
                    <div class="error-div">
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            <div class="exam-form-form-wrap">
                <div>
                    <label for="created_at">Kreirano: </label>
                    <input type="text" name="created_at" id="created_at" value="{{ $exam?->created_at_formatted }}" disabled>
                </div>
            </div>
                @error('created_at')
                    <div class="error-div">
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            <div class="exam-form-form-wrap">
                <div>
                    <label for="updated_at">Ažurirano: </label>
                    <input type="text" name="updated_at" id="updated_at" value="{{ $exam?->updated_at_formatted }}" disabled>
                </div>
            </div>
                @error('updated_at')
                    <div class="error-div">
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            <div class="exam-form-form-wrap">
                <button class="{{ !$exam?->num_of_questions ? 'danger' : '' }}" {{ !$exam?->num_of_questions ? 'disabled' : '' }}>Pokreni provjeru znanja</button>
                <button type="submit">Spremi promjene</button>
                <button>Obriši provjeru znanja</button>
            </div>
        </div>
        </form>
        <div>
            <div class="exam-form-content">
                <h4>Pitanja</h4>
                <div class="exam-form-form-wrap">
                    <a class="exam-details-btn" href="#">Pregled pitanja</a>
                    <a class="exam-details-btn" href="{{ route('teacher.create_questions', $exam) }}">Kreiranje pitanja</a>
                </div>
            </div>
        </div>

        <div>
            <div class="exam-form-content">
                <h4>Gamifikacija (kviz)</h4>
                <div class="exam-form-form-wrap">
                    <a class="exam-details-btn" href="#">Podijeli</a>
                </div>
            </div>
        </div>
    </div>
</div>
