<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class FacultyController extends Controller
{

    /**
     * current route root extractor
     *
     * @var string $current_route
     */
    public ?string $current_route = null;

    public function __construct() {
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
        $faculties =  Department::where('university_id',Auth::user()->university->id)->get();

        return view('pages.university.faculty.list', ['faculties'=> $faculties]);
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

        return view('pages.'.$this->current_route.'.faculty.add', ['faculty_head_list'=>$faculty_head_list]);
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
            'company_id' => 'nullable|exists:\App\Models\Company,id|integer',
            'university_id' => 'nullable|exists:\App\Models\University,id|integer',
            'head_id' => 'nullable|exists:\App\Models\User,id|integer',
            'name' => 'string|required',
            'description' => 'nullable|string'
        ]);
    
        // Ensure either company_id or university_id is provided
        if (!$request->filled('company_id') && !$request->filled('university_id')) {
            return back()->withErrors(['message' => 'Either a company or a university identifier is required.']);
        }
    
        // create new instance of Department
        $data = new Department($request->all());
    
        // saving new instance in db and returning message
        if ($data->save()) {
            // updating head user
            if ($request->get('head_id')) {
                User::find($request->get('head_id'))->update(['type' => '5']);
            }
            return redirect()->route($this->current_route.'.faculty.add')->with('success', 'Faculty has been stored successfully!');
        } else {
            return redirect()->route($this->current_route.'.faculty.add')->with('error', 'Something went wrong, please try again!');
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
        if($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty, self::ACTION_VIEW)){
            return view('pages.'.$this->current_route.'.faculty.view', ['faculty'=> $faculty]);
        }else{
            return redirect()->route($this->current_route.'.home')->with('error', 'You are not Authorized for this action!');
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
        if($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty, self::ACTION_EDIT)){
            /**
             * available staffs which can be faculty head
             *
             * @var \App\Models\User faculty_head_list
             */
            $faculty_head_list = User::where('is_staff', '3')->where('type', '0')->get();

            return view('pages.'.$this->current_route.'.faculty.edit', ['faculty_head_list'=>$faculty_head_list, 'faculty'=>$faculty]);
        }else{
            return redirect()->route($this->current_route.'.home')->with('error', 'You are not Authorized for this action!');
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
        if($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty, self::ACTION_UPDATE)){
            /**
             * get all request parameters
             *
             * @var array $checker
            */
            $checker = $request->all();
            // delete _token param
            unset($checker['_token']);
            // check send data and stored data are the same
            if(array_intersect_assoc($faculty->attributesToArray(),$request->all()) == $checker){
                return redirect()->route($this->current_route.'.faculty.edit', $faculty->id)->with('success', 'Nothing to update!');
            }
            // validating request
            $request->validate([
                'company_id' => 'exists:\App\Models\Company,id|integer|nullable',
                'university_id' => 'exists:\App\Models\University,id|integer|nullable',
                'head_id' => 'exists:\App\Models\User,id|integer|nullable',
                'name' => 'string|nullable',
                'description' => 'string|nullable'
            ]);
            // updating head user
            if($request->get('head_id')){
                User::find($request->get('head_id'))->update(['type' => '5']);
            }else{
                if($faculty->head) $faculty->head->update([ 'type' => '0']);
            }
            // update the instance and return message
            if($faculty->update($request->all())){
                return redirect()->route($this->current_route.'.faculty.edit', $faculty->id)->with('success', 'Department has been updated successfully!');
            }else{
                return redirect()->route($this->current_route.'.faculty.edit', $faculty->id)->with('error', 'Something went wrong, please try again!');
            }
        }else{
            return redirect()->route($this->current_route.'.home')->with('error', 'You are not Authorized for this action!');
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
        if($this->checkAuthorizations(self::MODEL_DEPARTMENT, auth()->user()->type, $faculty, self::ACTION_DELETE)){

            // delete the instance and return message
            if($faculty->delete()){
                return redirect()->route($this->current_route.'.faculty.list')->with('success', "Faculty has been deleted successfully!");
            }else{
                return redirect()->route($this->current_route.'.faculty.list')->with('error', 'Something went wrong, please try again!');
            }
        }else{
            return redirect()->route($this->current_route.'.home')->with('error', 'You are not Authorized for this action!');
        }
    }
}
