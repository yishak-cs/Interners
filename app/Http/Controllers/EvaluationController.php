<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|json',
            'department_id' => 'required|integer|exists:\App\Models\Department,id',
            'description' => 'nullable|string',
            'status' => 'required|in:1,0'
        ]);

        $evaluation = new Evaluation([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'department_id' => $request->input('department_id'),
            'description' => $request->input('description'), // Using the input method
            'status' => $request->input('status'),
        ]);

        if ($evaluation->save()) {
            return response([
                'message' => 'Evaluation has been successfaully stored!'
            ], 200);
        } else {
            return response([
                'message' => 'Something went wrong, please try again!'
            ], 500);
        }
    }
}
