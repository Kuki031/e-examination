<x-header />

<div class="exam-form-main">
    <div class="exam-form-wrap">
        <div class="exam-form-content">
            <h2>Nova provjera znanja</h2>
        </div>
        <div class="exam-form-content">
            <form class="exam-form-form" action="{{ route('teacher.create_exam') }}" method="POST">
                @csrf
                @include('exams._form')
                <div class="exam-form-form-wrap">
                    <button type="submit">Kreiraj provjeru znanja</button>
                </div>
            </form>
        </div>
    </div>
</div>
