<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\FacultyDepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class FacultyDepartmentController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('pages.' . $this->current_route . '.department.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // validating request
        $request->validate([
            'faculty_id' => 'required|exists:\App\Models\department,id|integer',
            'name' => 'string|required',
            'description' => 'nullable|string'
        ]);

        // create new instance of Department
        $data = new FacultyDepartment($request->all());

        // saving new instance in db and returning message
        if ($data->save()) {

            return redirect()->route($this->current_route . '.department.add')->with('success', 'Department has been stored successfully!');
        } else {
            return redirect()->route($this->current_route . '.department.add')->with('error', 'Something went wrong, please try again!');
        }
    }

    /**
     * Display a listing of the resource which belongs to the faculty
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        /**
         * all available departments
         *
         * @var \App\Models\Department $departments
         */
        $faculty_departments =  FacultyDepartment::where('faculty_id', Auth::user()->department->id)->get();

        return view('pages.' . $this->current_route . '.department.list', ['faculty_departments' => $faculty_departments]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacultyDepartment $faculty
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(FacultyDepartment $faculty_department): View|RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty_department, self::ACTION_VIEW)) {
            return view('pages.' . $this->current_route . '.department.view', ['faculty_department' => $faculty_department]);
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacultyDepartment  $faculty
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(FacultyDepartment $faculty_department): View|RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty_department, self::ACTION_EDIT)) {
            /**
             * available staffs which can be faculty head
             *
             * @var \App\Models\User faculty_head_list
             */
            return view('pages.' . $this->current_route . '.department.edit', ['faculty_department' => $faculty_department]);
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacultyDepartment $faculty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, FacultyDepartment $faculty_department): RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty_department, self::ACTION_UPDATE)) {
            /**
             * get all request parameters
             *
             * @var array $checker
             */
            $checker = $request->all();
            // delete _token param
            unset($checker['_token']);
            // check send data and stored data are the same
            if (array_intersect_assoc($faculty_department->attributesToArray(), $request->all()) == $checker) {
                return redirect()->route($this->current_route . '.department.edit', $faculty_department->id)->with('success', 'Nothing to update!');
            }
            // validating request
            $request->validate([
                'faculty_id' => 'required|exists:\App\Models\department,id|integer',
                'name' => 'string|nullable',
                'description' => 'nullable|string'
            ]);

            // update the instance and return message
            if ($faculty_department->update($request->all())) {
                return redirect()->route($this->current_route . '.department.edit', $faculty_department->id)->with('success', 'Department has been updated successfully!');
            } else {
                return redirect()->route($this->current_route . '.departmnet.edit', $faculty_department->id)->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacultyDepartment $faculty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(FacultyDepartment $faculty_department): RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty_department, self::ACTION_DELETE)) {

            // delete the instance and return message
            if ($faculty_department->delete()) {
                return redirect()->route($this->current_route . '.department.list')->with('success', "Faculty has been deleted successfully!");
            } else {
                return redirect()->route($this->current_route . '.department.list')->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }
}
