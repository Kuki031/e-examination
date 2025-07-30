<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExamRequest;
use App\Models\Exam;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    use ToastInterface, Search;
    public function getCreateForm()
    {
        return view("exams.create");
    }

    public function createExam(CreateExamRequest $createExamRequest)
    {
        $validated = $createExamRequest->validated();
        $validated['user_id'] = Auth::id();
        Exam::create($validated);

        $this->constructToastMessage("Provjera znanja uspješno kreirana!", "Uspješno", "success");
        return to_route("teacher.teacher_exams");

    }

    public function getQuestionMakerForExam(Exam $exam)
    {
        if (!$exam)
        {
            $this->constructToastMessage("Provjera znanja ne postoji!", "Resurs ne postoji", "error");
            return back();
        }

        return view("exams.questionMaker", compact("exam"));
    }

    public function getExamDetails(Exam $exam)
    {
        return view("exams.details", compact("exam"));
    }

    public function getMyExams()
    {
        $exams = $this->searchAny(Exam::class, ['name'])
            ->where('user_id', "=", Auth::id())
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('exams.list', compact('exams'));
    }
}
