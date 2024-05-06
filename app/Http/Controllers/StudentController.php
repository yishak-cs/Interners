<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Department;
use App\Models\UserApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class StudentController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $students = User::with('applications') // Eager load the applications relationship
            ->whereIn('department_id', function ($query) {
                $query->select('id')
                    ->from('departments')
                    ->where('head_id', Auth::user()->id);
            })->get();

        // Initialize an array to hold the stats for each student
        $studentsStats = [];

        foreach ($students as $student) {
            // Initialize stats for the current student
            $stats = [0, 0, 0];

            foreach ($student->applications as $application) {
                if ($application != null) {
                    $stats[(int)$application->status]++;
                }
            }
            // Store the stats in the array with the student's ID as the key
            $studentsStats[$student->id] = $stats;
        }

        return view('pages.' . $this->current_route . '.students.list', [
            'students' => $students,
            'studentsStats' => $studentsStats
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $student
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(User $student): View|RedirectResponse
    {
        // Check authorization
        if ($this->checkAuthorizations(self::MODEL_STUDENTS, auth()->user()->type, $student, self::ACTION_VIEW)) {
            // Find the accepted application for the given student

            // i know this shouldnt be first() at the end because a student can have multiple 
            // applications with status=1 so needs fixing
            $acceptedApplication = $student->applications()->where('status', 1)->first();

            if ($acceptedApplication) {
                // Return the view with the accepted application and related data
                return view('pages.' . $this->current_route . '.students.view', [
                    'user_application' => $acceptedApplication,
                    'internship' => $acceptedApplication->internship,
                    'user' => $acceptedApplication->user,
                    'prerequisite_responses' => $acceptedApplication->prerequisiteResponses,
                ]);
            } else {
                // If no accepted application found, return the view with only the student data
                return view('pages.' . $this->current_route . '.students.view', [
                    'user_application' => '',
                    'internship' => '',
                    'user' => $student,
                    'prerequisite_responses' => '',
                ]);
            }
        } else {
            // If not authorized, redirect with an error message
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  User $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $student): RedirectResponse
    {
        // check authorization
        if($this->checkAuthorizations(self::MODEL_STUDENTS, auth()->user()->type, $student, self::ACTION_DELETE)){
            // delete the instance and return message
            if($student->delete()){
                return redirect()->back()->with('success', "Student has been deleted successfully!");
            }else{
                return redirect()->back()->with('error', 'Something went wrong, please try again!');
            }
        }else{
            return redirect()->route($this->current_route.'.home')->with('error', 'You are not Authorized for this action!');
        }
    }

}
