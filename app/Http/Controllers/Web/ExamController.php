<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ExamController extends Controller
{
    public function show($id){
        $data['exam'] = Exam::findOrFail($id);
        $data['skill'] = $data['exam']->skill;

        $data['canViewStartBtn'] = true;

        // Status 
        $user = Auth::user();
        if($user !== null){
            $pivotRow = $user->exams()->where('exam_id', $id)->first();

            // check if enter exam before 
            if ($pivotRow !== null and $pivotRow->pivot->status == 'closed'){ // if not enter exam before --> return null
                $data['canViewStartBtn'] = false;
            }

        }
        return view('web.exams.show')->with($data);

    }

    public function start($examId, Request $request){
        // $userId = Auth::id(); // id of user that logged in 
        $user = Auth::user(); 
        // attach -> to add in pivot table
        if (! $user->exams->contains($examId)){
            $user->exams()->attach($examId);
        }else{
            $user->exams()->updateExistingPivot($examId , [
                'status' => 'closed',
            ]);
        }


        $request->session()->flash('prev', "start/$examId");

        return redirect(url("exams/questions/$examId"));

    }

    public function questions($examId , Request $request){

        // check if previous page is start
        if (session('prev') !== "start/$examId"){
            return redirect(url("exams/show/$examId"));
        }

        $data['exam'] = Exam::findOrFail($examId);
        $data['skill'] = $data['exam']->skill;

        $request->session()->flash('prev', "questions/$examId");

        return view('web.exams.questions')->with($data);
    }

    public function submit($examId , Request $request){
        // dd($request->all());

        // check if previous page is questions
        if (session('prev') !== "questions/$examId"){
            return redirect(url("exams/show/$examId"));
        }


        $request->validate([
            'answers' => 'required|array',
            // each value of answers 
            'answers.*' => 'required|in:1,2,3,4'
        ]);

        // Calculation Score 
        $exam = Exam::findOrFail($examId);

        $points = 0;
        $totalQuesNum = $exam->questions->count();

        foreach ($exam->questions as $question) {
            if (isset($request->answers[$question->id])){
                $userAns = $request->answers[$question->id];
                $rightAns = $question->right_ans;

                if($userAns == $rightAns){
                    $points += 1;
                }
            }
        }

        $score = ($points/$totalQuesNum) * 100;

        // dd($score);

        // Calculation Time Mins
        $user = Auth::user();
        $pivotRow = $user->exams()->where('exam_id', $examId)->first();
        $startTime = $pivotRow->pivot->created_at;
        $submitTime = Carbon::now();

        $timeMins = $submitTime->diffInMinutes($startTime);

        if($timeMins > $pivotRow->duration_mins){
            $score = 0;
        }

        // update pivot row
        $user->exams()->updateExistingPivot($examId, [
            'score' => $score,
            'time_mins' => $timeMins,
        ]);

        //dd($timeMins);

        $request->session()->flash("success", "You Finished Exam Successfully with score $score%");
        return redirect(url("exams/show/$examId"));
    }

}
