<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function show($id){
        $data['skill'] = Skill::findOrFail($id);
        $data['exams'] = $data['skill']->exams()->active()->paginate(6);

        return view('web.skills.show')->with($data);
    }
}
