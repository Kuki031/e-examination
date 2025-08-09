<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    use ToastInterface, Search;
    public function startExam(Exam $exam)
    {
        if (!$exam->required_for_pass) {
            $this->constructToastMessage("Nije definiran broj bodova potreban za prolaz.", "Neuspjelo pokretanje ispita", "error");
            return back();
        }
        if (!$exam->access_code) {
            $this->constructToastMessage("Nije generiran pristupni kod za provjeru znanja.", "Neuspjelo pokretanje ispita.", "error");
            return back();
        }

        $exam->update([
            "in_process" => true,
            "start_time" => Carbon::now()
        ]);

        $this->constructToastMessage("Prijava znanja uspješno pokrenuta. Kako bi studenti mogli pristupiti istoj, morate im podijeliti pristupni kod.", "Uspjeh", "success", 4500);
        return back();
    }

    public function stopExam(Exam $exam) {
        if (!$exam->in_process) {
            $this->constructToastMessage("Prijava znanja nije pokrenuta.", "Neuspjeh", "error");
            return back();
        }

        $exam->update([
            "in_process" => false,
            "end_time" => Carbon::now()
        ]);

        $this->constructToastMessage("Provjera znanja uspješno zaustavljena.", "Uspjeh", "success");
        return back();
    }
}
