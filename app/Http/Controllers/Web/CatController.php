<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use Illuminate\Http\Request;


class CatController extends Controller
{
    public function show($id){
        $data['cat'] = Cat::findOrFail($id);
        $data['allCats'] = Cat::select('id', 'name')->active()->get();

        $data['skills'] = $data['cat']->skills()->active()->paginate(6);


        return view('web.cats.show')->with($data);
    }
}

