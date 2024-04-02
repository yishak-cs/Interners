<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;


class CompanyController extends Controller
{
    //
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
        /**
         * all available company
         *
         * @var \App\Models\Company $companies
         */
        $companies =  Company::all();

        return view('pages.admin.company.list', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        /**
         * available staffs which can be company head
         *
         * @var \App\Models\User $company_head_list
         */
        $company_head_list = User::where('is_staff', '1')->where('type', '0')->get();

        return view('pages.admin.company.add', ['company_head_list' => $company_head_list]);
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
            'type' => '4',
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

            // create new company instance
            $data = new Company([
                'name' => $request->input('name'),
                'head_id' => $user_login->id,
                'description' => $request->description,
            ]);
            // saving new instance in db and returning message
            if ($data->save()) {
                // updating head user
                if ($request->get('head_id')) {
                    User::find($request->get('head_id'))->update(['type' => '4']);
                }
                return redirect()->route('admin.company.add')->with('success', 'Company has been stored successfully!');
            } else {
                return redirect()->route('admin.company.add')->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route('admin.company.add')->with('error', 'Something went wrong, please try again!');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Company $company): View|RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_COMPANY, auth()->user()->type, $company, self::ACTION_VIEW)) {
            return view('pages.admin.company.view', ['company' => $company]);
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Company $company): View|RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_COMPANY, auth()->user()->type, $company, self::ACTION_EDIT)) {
            /**
             * available staffs which can be company head
             *
             * @var \App\Models\User $company_head_list
             */
            $company_head_list = User::where('is_staff', '1')->where('type', '0')->get();

            return view('pages.admin.company.edit', ['company_head_list' => $company_head_list, 'company' => $company]);
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Company $company): RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_COMPANY, auth()->user()->type, $company, self::ACTION_UPDATE)) {
            /**
             * get all request parameters
             *
             * @var array $checker
             */
            $checker = $request->all();
            // delete _token param
            unset($checker['_token']);
            // check send data and stored data are the same
            if (array_intersect_assoc($company->attributesToArray(), $request->all()) == $checker) {
                return redirect()->route('admin.company.edit', $company->id)->with('success', 'Nothing to update!');
            }
            // validating request
            $request->validate([
                'head_id' => 'exists:\App\Models\User,id|integer|nullable',
                'name' => 'string|nullable',
                'description' => 'string|nullable'
            ]);
            // updating head user
            if ($request->get('head_id')) {
                User::find($request->get('head_id'))->update(['type' => '4']);
            } else {
                if ($company->head) $company->head->update(['type' => '0']);
            }
            // update the instance and return message
            if ($company->update($request->all())) {
                return redirect()->route('admin.company.edit', $company->id)->with('success', 'Company has been updated successfully!');
            } else {
                return redirect()->route('admin.company.edit', $company->id)->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company): RedirectResponse
    {
        // check authorization
        if ($this->checkAuthorizations(self::MODEL_COMPANY, auth()->user()->type, $company, self::ACTION_DELETE)) {

            // delete the instance and return message
            if ($company->delete()) {
                return redirect()->route('admin.company.list')->with('success', "Company has been deleted successfully!");
            } else {
                return redirect()->route('admin.company.list')->with('error', 'Something went wrong, please try again!');
            }
        } else {
            return redirect()->route($this->current_route . '.home')->with('error', 'You are not Authorized for this action!');
        }
    }
}
