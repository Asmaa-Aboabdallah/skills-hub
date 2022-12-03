<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function show($id)
    {
         $exam = Exam::findOrFail($id);
         return new ExamResource($exam);
    }

    public function showQuestions($id)
    {
         $exam = Exam::with('questions')->findOrFail($id);
         return new ExamResource($exam);
    }

    public function start($examId, Request $request){

        // dd($request->user());
       $request->user()->exams()->attach($examId);
        
        return response()->json([
            'message' => 'you started exam'
        ]);

    }


    public function submit($examId , Request $request){

        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*' => 'required|in:1,2,3,4'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

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

        // Calculation Time Mins
        $user = $request->user();
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

        return response()->json([
            'message' => "you submitted exam successfully , your score is $score"
        ]);
        
    }
}
