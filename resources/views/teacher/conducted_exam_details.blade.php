<x-header />


<div class="exam-form-main">
    <div class="exam-form-wrap">

        <div class="exam-form-section">
            <div class="exam-form-content">
                <h4>Osnovne informacije</h4>

                @foreach ([
                    ['exam_id', "ID ispita", $conductedExam->exam?->id],
                    ['id', "ID inačice ispita", $conductedExam->id],
                    ['name', 'Naziv', $conductedExam->exam?->name],
                    ['num_of_participants', 'Broj pristupnika', $conductedExam->num_of_participants],
                    ['time_to_solve', 'Raspoloživo vrijeme za rješavanje (min.)', $conductedExam->time_to_solve],
                    ['required_for_pass', 'Potrebno za prolaz', $conductedExam->required_for_pass],
                    ['num_of_questions', 'Broj pitanja', $conductedExam->num_of_questions],
                    ['num_of_points', 'Ukupan broj bodova', $conductedExam->num_of_points],
                    ['in_process', 'U procesu', $conductedExam->exam?->in_process ? 'Da' : 'Ne'],
                    ['start_time', 'Početak', $conductedExam->start_time_formatted],
                    ['end_time', 'Kraj', $conductedExam->end_time_formatted],
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
                @endforeach
            </div>
        </div>

        <div class="exam-form-section">
            <div class="exam-form-content">
                <h4>Dodatne informacije</h4>

                @foreach ([
                    ["Broj položenih ispita", $passes],
                    ["Broj nepoloženih ispita", $fails]
                ] as [$label, $value])
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
                @endforeach
                <a class="exam-details-btn" href="{{ route('teacher.conducted_exam_participants', [$conductedExam, $conductedExam->exam]) }}">Sudionici</a>
            </div>
        </div>
    </div>
</div>
