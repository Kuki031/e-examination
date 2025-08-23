<x-header />


@php
    $activites = $attempt?->actions;
    $questions = $attempt?->questions;
    $answers = json_decode($attempt?->stored_answers);
    $correctAnswers = [];
@endphp


<div class="tables-main">
@if ($activites && sizeof($activites) > 0)

<div class="table-wrap">
    <div>
        <div class="table-title">
            <h2>Aktivnosti</h2>
        </div>

        <table class="table-main">
            <thead>
                <tr>
                    <th>Vrijeme</th>
                    <th>Aktivnost</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($activites as $activity)
                    <tr>
                        <td>{{ $activity['time'] }}</td>
                        <td>{{ $activity['activity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div>
    <h1 style="color: #1F2A44; margin-top: 1rem;">Nema aktivnosti.</h1>
</div>
@endif


<div class="table-wrap">
    <div>
        <div class="table-title">
            <h2>Generirana pitanja</h2>
        </div>

        <table class="table-main">
            <thead>
                <tr>
                    <th>Pitanje</th>
                    <th>Odgovori</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 0;
                    $j = 0;
                @endphp
                @foreach ($questions as $question)
                @php $j++; @endphp
                    <tr>
                        <td>{{ $j }}. {{ $question['question'] }}</td>
                        <td>
                        @foreach ($question['answers'] as $key => $answer)
                            @php $i++ @endphp

                            @if ($key === 'is_correct')
                                @php $correctAnswers[] = $answer @endphp
                            @endif

                            <span style="{{ $key === 'is_correct' ? 'color: green;' : '' }}">{{ $key === 'is_correct' ? 'Točan: ' : "{$i}." }}{{ $answer }}</span>
                        @endforeach
                        @php $i = 0 @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@if ($answers)
    <div class="table-wrap">
    <div>
        <div class="table-title">
                <h2>Poslani odgovori</h2>
            </div>

            <table class="table-main">
                <thead>
                    <tr>
                        <th>Odgovor</th>
                    </tr>
                </thead>
                @php $i = 0; @endphp
                <tbody>
                    @foreach ($answers as $answer)
                        @php $i++; @endphp
                        <tr>
                            <td>{{ $i }}. <span style="{{ in_array($answer, $correctAnswers) ? 'color: green;' : 'color:red;' }}">{{ $answer }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
@endif
</div>
