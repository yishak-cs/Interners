<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class EvaluationController extends Controller
{
    /**
     * current route root extractor
     *
     * @var string $current_route
     */
    public ?string $current_route = null;

    public function __construct()
    {
        $this->current_route = explode('.', Route::currentRouteName())[0];
    }

    public function index()
    {
        $evaluations = Evaluation::where('department_id', auth()->user()->department->id)->get();

        return view('pages.' . $this->current_route . '.evaluation.list', ['evaluations' => $evaluations]);
    }
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evaluation $evaluation
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Evaluation $evaluation)
    {

        if ($this->checkAuthorizations(self::MODEL_EVALUATION, Auth::user()->type, $evaluation, self::ACTION_VIEW)) {
            return view('pages.' . $this->current_route . '.evaluation.view', ['evaluation' => $evaluation]);
        } else {
            return redirect()->back()->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evalation $evaluation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Evaluation $evaluation): RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_EVALUATION, auth()->user()->type, $evaluation, self::ACTION_DELETE)) {

            // delete the instance and return message
            if ($evaluation->delete()) {
                return redirect()->back()->with('success', "Evaluation has been deleted successfully!");
            } else {
                return redirect()->back()->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Evaluation $evaluation
     * @return RedirectResponse
     */
    public function updateStatus(Request $request, Evaluation $evaluation): RedirectResponse
    {
        // validating
        $request->validate([
            'status' => 'required|in:1,0'
        ]);

        if ($this->checkAuthorizations(self::MODEL_EVALUATION, auth()->user()->type, $evaluation, self::ACTION_UPDATE)) {
            if ($evaluation->update(['status' => $request->input('status')])) {
                return redirect()->back()->with('success', "Evaluation has been updated successfully!");
            }
            return redirect()->back()->with('error', 'Something went wrong, please try again!');
        }
        return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
    }
}
