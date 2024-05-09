<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\UserApplication;

class ResponseController extends Controller
{

    public function showForm(Request $request)
    {
        $userApplicationId= $request->input('userApplication');

        $userApplication=UserApplication::find($userApplicationId);

        $internName = $userApplication->user->getName();
     
        $evaluationId = $request->input('evaluation_form');
        
        $evaluation = Evaluation::find($evaluationId);
       
        $departmentName = $evaluation->department->name;

        $university = $evaluation->department->university->name;
        
        // Check if the evaluation is associated with the user application
        if (!$userApplication->evaluations->contains($evaluation)) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.department.response.add', compact('userApplication', 'evaluation', 'internName', 'departmentName','university'));
    }
}
