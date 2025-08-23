<x-header />

<div class="selector-main">
    <div class="selector-title-div">
        <h1 class="selector-title-heading">Odaberite vrstu registracije: </h1>
    </div>
        <div class="selector-wrap">
            <div class="selector-admin-teacher">
                <div>
                    <a href="{{ route('auth.teacher_register_form') }}">Nastavnik</a>
                </div>
            </div>
            <div class="selector-student">
                <div>
                    <a href="{{ route('auth.student_register_form') }}">Student</a>
                </div>
            </div>
    </div>
</div>
