<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\UserApplication;

class ResponseController extends Controller
{

    public function showForm(UserApplication $userApplication, Request $request)
    {
        $internName = $userApplication->user->getName();
        $evaluationId = $request->input('evaluation_form');
        $evaluation = Evaluation::findOrFail($evaluationId);
        $departmentName = $evaluation->department->name;

        // Check if the evaluation is associated with the user application
        if (!$userApplication->evaluations->contains($evaluation)) {
            abort(403, 'Unauthorized action.');
        }

        return view('department.evaluation.response', compact('userApplication', 'evaluation', 'internName', 'departmentName'));
    }
}
