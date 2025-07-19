<x-header />

<div class="selector-main">
    <div class="selector-title-div">
        <h1 class="selector-title-heading">Odaberite vrstu prijave: </h1>
    </div>
        <div class="selector-wrap">
            <div class="selector-admin-teacher">
                <div>
                    <a href="{{ route("auth.teacher_login_form") }}">Administrator/nastavnik</a>
                </div>
            </div>
            <div class="selector-student">
                <div>
                    <a href="{{ route('auth.student_login_form') }}">Student</a>
                </div>
            </div>
    </div>
</div>
