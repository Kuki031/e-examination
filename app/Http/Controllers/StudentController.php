<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    use ToastInterface, Search;
    public function getAvailableExamList()
    {
        $exams = $this->searchAny(Exam::class, ['name'])
            ->where('in_process', "=", true)
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('exams.process.list', compact('exams'));
    }

    public function getExamConfirmationView(Exam $exam)
    {
        return view("exams.process.welcome", compact("exam"));
    }
}
