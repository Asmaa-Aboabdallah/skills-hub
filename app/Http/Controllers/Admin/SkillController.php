<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use App\Models\Skill;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function index()
    {
       //  $data['cats'] = Cat::get();
       $data['skills'] = Skill::orderBy('id', 'DESC')->paginate(10);
       $data['cats'] = Cat::select('id', 'name')->get();
       return view('admin.skills.index')->with($data);
 
    }

    public function store(Request $request)
    {
       $request->validate([
          'name_en' => 'required|string|max:50',
          'name_ar' => 'required|string|max:50',
          'img' => 'required|image|max:2048',
          'cat_id' => 'required|exists:cats,id'
       ]);

       $path = Storage::putFile("skills", $request->file('img'));


       Skill::create([
          'name' => json_encode([
             'en' => $request->name_en,
             'ar' => $request->name_ar,
          ]),
          'img' =>  $path,
          'cat_id' => $request->cat_id,
       ]);

       $request->session()->flash('msg', 'Skill Added Successfuly');
       return back();
       
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:skills,id',
            'name_en' => 'required|string|max:50',
            'name_ar' => 'required|string|max:50',
            'img' => 'nullable|image|max:2048',
            'cat_id' => 'required|exists:cats,id'
         ]);


       $skill = Skill::findOrFail($request->id);
        // اجيب المسار القديم اللي موجود في الداتا بيز
       $path = $skill->img;
   
        // في حاله انه مرفعش صورة هتفضل زي ماهي 
        // في حاله انه رفع هعمل check
       if ($request->hasFile('img')){
           Storage::delete($path);
           $path = Storage::putFile("skills", $request->file('img'));
       }
 
       $skill->update([
          'name' => json_encode([
             'en' => $request->name_en,
             'ar' => $request->name_ar,
          ]),
          'img' =>  $path,
          'cat_id' => $request->cat_id,
       ]);


       $request->session()->flash('msg', 'Skill Updated Successfuly');
       return back();
       
    }

    public function delete(Skill $skill , Request $request) // route model pinding
   {
      try {
         $path = $skill->img;
         $skill->delete();
         Storage::delete($path);
         $msg = "Skill Deleted Successfuly";
      } catch (Exception $e) {
         $msg = "Can't Delete this Skill";
      }
      $request->session()->flash('msg', $msg);
      
      return back();
   }

   public function toggle(Skill $skill)
   {
      $skill->update([
         'active' => ! $skill->active
      ]);
      return back();

   }
}
