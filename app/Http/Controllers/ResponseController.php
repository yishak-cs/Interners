<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\UserApplication;
use App\Models\EvaluationResponse;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{

    public function showForm(Request $request)
    {

        $userApplicationId = $request->input('userApplication');
        $userApplication = UserApplication::find($userApplicationId);
        $internName = $userApplication->user->getName();
        $evaluationId = $request->input('evaluation_form');
        $evaluation = Evaluation::find($evaluationId);
        $departmentName = $evaluation->department->name;
        $university = $evaluation->department->university->name;

        $existingEvaluation = EvaluationResponse::where('user_id', $userApplication->user->id)
            ->where('evaluation_id', $evaluation->id)
            ->first();

        if ($existingEvaluation) {
            // Handle the case where the evaluation already exists
            return redirect()->back()->with(['error' => 'This intern has already been evaluated with the selected form.']);
        }

        // Check if the evaluation is associated with the user application
        if (!$userApplication->evaluations->contains($evaluation)) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.department.response.add', compact('userApplication', 'evaluation', 'internName', 'departmentName', 'university'));
    }

    public function store(Request $request)
    {

        $data = $request->all();
        // removing unwanted fields
        unset($data['intern_id']);
        unset($data['evaluation_id']);
        unset($data['body_preview']);
        unset($data['_token']);
        unset($data['company_id']);

        // attrs
        $attributes = [
            'body'  => $data,
            'body_preview'  => $request->get('body_preview'),
            'evaluation_id' => $request->input('evaluation_id'),
            'user_id' => $request->input('intern_id'),
            'company_id' => $request->input('company_id')
        ];
        $response = new EvaluationResponse($attributes);

        if ($response->save()) {

            return redirect()->back()->with('success', 'Intern evaluation successfully sent');
        } else {
            return redirect()->back()->with('error', 'something went wrong');
        }
    }

    public function index(Request $request)
    {
        $responses = EvaluationResponse::whereIn('evaluation_id', function ($query) {
            $query->select("id")
                ->from("evaluations")
                ->where("department_id", auth()->user()->department->id)
                ->where("deleted_at", null);
        })->where("deleted_at", null);
        
        $evaluations = Auth::user()->department->evaluations;
        $departments= Auth::user()->department->facultyDepartment;
        /**
         * Filters
         */
        $filter = $request->all() ?: [];
        
        // check for evaluation filter
        if (isset($filter['evaluation_id'])) {
            $responses->where('evaluation_id', $filter['evaluation_id']);
        }
        
        // check for department filter
        if (isset($filter['fdepartment_id'])) {
            $responses->whereHas('evaluated', function ($query) use ($filter) {
                $query->where('fdepartment_id', $filter['fdepartment_id']);
            });
        }
        
        // unsetting filter
        if (!isset($filter['department_id']) && !isset($filter['type']) && !isset($filter['evaluation_id']) && !isset($filter['fdepartment_id'])) {
            unset($filter);
        }
        
        $responses = $responses->get();
        return view('pages.faculty.response.list', [
            'responses' => $responses,
            'evaluations' => $evaluations,
            'filter' => $filter ?? null,
            'departments' => $departments
        ]);
    }

    public function show(EvaluationResponse $response){
      
        return view('pages.faculty.response.view', ['response'=>$response]);

    }
}
