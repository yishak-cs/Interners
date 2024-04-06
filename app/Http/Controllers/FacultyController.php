<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\View\View;
use App\Models\Department;
use App\Models\University;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class FacultyController extends Controller
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
     * Display a listing of the resource which belongs to one University
     *
     * @return \Illuminate\View\View
     */
    public function universityIndex(): View
    {
        /**
         * all available facultiess
         *
         * @var \App\Models\Department $faculties
         */
        $faculties =  Department::where('university_id', Auth::user()->university->id)->get();

        return view('pages.university.faculty.list', ['faculties' => $faculties]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        /**
         * available staffs which can be faculty head
         *
         * @var \App\Models\User faculty_head_list
         */
        $faculty_head_list = User::where('is_staff', '3')->where('type', '0')->get();

        return view('pages.' . $this->current_route . '.faculty.add', ['faculty_head_list' => $faculty_head_list]);
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
            'university_id' => 'required|exists:\App\Models\University,id|integer',
            'head_id' => 'nullable|exists:\App\Models\User,id|integer',
            'name' => 'string|required',
            'description' => 'nullable|string',
            'email' => 'email|required|unique:\App\Models\User,email',
            'password' => 'string|required|confirmed|min:8',
            'first_name' => 'string|required',
            'middle_name' => 'string|required',
            'last_name' => 'string|nullable'
        ]);

        $staffType = $request->input('staff_type');
        // create a new user instance
        $user_login = new User([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'email_verified_at' => \Carbon\Carbon::now()->timezone('Africa/Addis_Ababa')->format('Y-m-d H:i:s'),
            'type' => '5',
            'is_staff' => $staffType
        ]);
        if ($user_login->save()) {
            /**
             * creating user information
             *
             * @var \Illuminate\Models\userInformation
             */
            UserInformation::create([
                'user_id' => $user_login->id,
                'first_name' => $request->get('first_name'),
                'middle_name' => $request->get('middle_name'),
                'last_name' => $request->get('last_name') ?? ''
            ]);

            // create new instance of Department
            $data = new Department([
                'university_id' => $request->university_id,
                'name' => $request->input('name'),
                'head_id' => $user_login->id,
                'description' => $request->description,
            ]);
            // saving new instance in db and returning message
            if ($data->save()) {
                // updating head user
                if ($request->get('head_id')) {
                    User::find($request->get('head_id'))->update(['type' => '5']);
                }
                return redirect()->route($this->current_route . '.faculty.add')->with('success', 'Faculty has been stored successfully!');
            } else {
                return redirect()->route($this->current_route . '.faculty.add')->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route($this->current_route . '.faculty.add')->with('error', 'Something went wrong, please try again!');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department $faculty
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Department $faculty): View|RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty, self::ACTION_VIEW)) {
            return view('pages.' . $this->current_route . '.faculty.view', ['faculty' => $faculty]);
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $faculty
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Department $faculty): View|RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty, self::ACTION_EDIT)) {
            /**
             * available staffs which can be faculty head
             *
             * @var \App\Models\User faculty_head_list
             */
            $faculty_head_list = User::where('is_staff', '3')->where('type', '0')->get();

            return view('pages.' . $this->current_route . '.faculty.edit', ['faculty_head_list' => $faculty_head_list, 'faculty' => $faculty]);
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department $faculty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Department $faculty): RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty, self::ACTION_UPDATE)) {
            /**
             * get all request parameters
             *
             * @var array $checker
             */
            $checker = $request->all();
            // delete _token param
            unset($checker['_token']);
            // check send data and stored data are the same
            if (array_intersect_assoc($faculty->attributesToArray(), $request->all()) == $checker) {
                return redirect()->route($this->current_route . '.faculty.edit', $faculty->id)->with('success', 'Nothing to update!');
            }
            // validating request
            $request->validate([
                'university_id' => 'exists:\App\Models\University,id|integer|nullable',
                'head_id' => 'exists:\App\Models\User,id|integer|nullable',
                'name' => 'string|nullable',
                'description' => 'string|nullable'
            ]);
            // updating head user
            if ($request->get('head_id')) {
                User::find($request->get('head_id'))->update(['type' => '5']);
            } else {
                if ($faculty->head) $faculty->head->update(['type' => '0']);
            }
            // update the instance and return message
            if ($faculty->update($request->all())) {
                return redirect()->route($this->current_route . '.faculty.edit', $faculty->id)->with('success', 'Department has been updated successfully!');
            } else {
                return redirect()->route($this->current_route . '.faculty.edit', $faculty->id)->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department $faculty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Department $faculty): RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty, self::ACTION_DELETE)) {

            // delete the instance and return message
            if ($faculty->delete()) {
                return redirect()->route($this->current_route . '.faculty.list')->with('success', "Faculty has been deleted successfully!");
            } else {
                return redirect()->route($this->current_route . '.faculty.list')->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    // for ajax 
    public function getFacultyDepartments($facultyId)
    {
        // Find the faculty by ID
        $faculty = Department::find($facultyId);

        // Get the departments associated with the university
        $departments = $faculty->facultyDepartment()->pluck('name', 'id');

        // Return the departments as a JSON response
        return response()->json($departments);
    }
}
