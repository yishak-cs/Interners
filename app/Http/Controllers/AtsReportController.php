<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Internship;
use Illuminate\Http\Request;
use App\Models\UserApplication;
use Illuminate\Support\Facades\Auth;

class AtsReportController extends Controller
{
    /**
     * Application listing for university, company, or department.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function applicationListing(Request $request): View
    {
        $user = auth()->user();
        $userType = $user->type;
        $entityId = null;
        $entityColumn = null;
        $viewPath = 'pages.' . $userType . '.reports.application'; 

        // Determine the entity ID and column based on the user type
        if ($userType === 'university') {
            $entityId = $user->university->id;
            $entityColumn = 'university_id';
        } elseif ($userType === 'company') {
            $entityId = $user->company->id;
            $entityColumn = 'company_id';
        } elseif ($userType === 'department' || $userType === 'faculty') {
            $entityId = $user->department->id;
            $entityColumn = 'department_id';
        }

        // Fetch internships and their applications based on the user type
        if ($userType === 'university' || $userType === 'company') {
            // Fetch internships posted by departments within the university or company
            $internships = Internship::whereHas('department', function ($query) use ($entityColumn, $entityId) {
                $query->where($entityColumn, $entityId);
            })->with('userApplications')->get();
        } else {
            // Fetch internships directly for 'department' or 'udepartment'
            $internships = Internship::where('department_id', $entityId)->with('userApplications')->get();
        }

        // Apply filters to the applications
        $applications = $internships->pluck('userApplications')->flatten(); // Flatten the collection of applications

        // Collect all filters from the request
        $filters = $request->all();

        // Validate the request data
        $request->validate([
            'status' => 'nullable|in:0,1,2',
            'start_date' => 'nullable|date_format:Y-m-d|before:end_date',
            'end_date' => 'nullable|date_format:Y-m-d|after:start_date',
            'internship' => 'nullable|exists:\App\Models\Internship,id',
            'date' => 'nullable|in:desc,asc',
        ]);

        // Apply each filter to the applications collection
        if ($request->filled('status')) {
            $applications = $applications->where('status', $request->status);
        }
        if ($request->filled('internship')) {
            $applications = $applications->where('internship_id', $request->internship);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $applications = $applications->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('date')) {
            $applications = $applications->sortBy('created_at', SORT_REGULAR, $request->date === 'desc');
        }

        // Determine if any filters have been activated
        $isFilterActivated = collect($filters)->filter()->isNotEmpty();

        // Return the view with the necessary data
        return view($viewPath, [
            'isFilterActivated' => $isFilterActivated,
            'filters' => $filters,
            'internships' => $internships,
            'applications' => $applications
        ]);
    }

    /**
     * Internship listing for university, company, or department.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function internshipListing(Request $request): View
    {
        $user = auth()->user();
        $userType = $user->type;
        $entityId = null;
        $entityColumn = null;
        $viewPath = 'pages.' . $userType . '.reports.internship'; 

        // Determine the entity ID and column based on the user type
        if ($userType === 'university') {
            $entityId = $user->university->id;
            $entityColumn = 'university_id';
        } elseif ($userType === 'company') {
            $entityId = $user->company->id;
            $entityColumn = 'company_id';
        } elseif ($userType === 'department' || $userType === 'faculty') {
            $entityId = $user->department->id;
            $entityColumn = 'department_id';
        }

        if ($userType === 'university' || $userType === 'company') {
            $internships = Internship::whereHas('department', function ($query) use ($entityColumn, $entityId) {
                $query->where($entityColumn, $entityId);
            })->get();
        } else {
            $internships = Internship::where('department_id', $entityId)->get();
        }

        /**
         * filters array
         *
         * @var array $filters
         */
        $filters = $request->all() ?? [];
        $request->validate([
            'status' => 'nullable|in:0,1,2,3,4',
            'start_date' => 'nullable|date_format:Y-m-d|before:end_date',
            'end_date' => 'nullable|date_format:Y-m-d|after:start_date',
            'date' => 'nullable|in:desc,asc',
        ]);

        // add filter for status
        if ($request->status != null) {
            $internships = $internships->where('status', $request->status);
        }

        // add filter for start and end date
        if ($request->start_date != null && $request->end_date != null) {
            $internships = $internships->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // add filter for date order
        if ($request->date != null) {
            $internships = $internships->orderBy('created_at', $request->date);
        }

         // Determine if any filters have been activated
         $isFilterActivated = collect($filters)->filter()->isNotEmpty();

        return view($viewPath, [
            'isFilterActivated' => $isFilterActivated,
            'filters' => $filters,
            'internships' => $internships,
        ]);
    }

    public function application(Request $request): View
    {
        $user = auth()->user();
        $userType = $user->type;
        $viewPath = 'pages.' . $userType . '.reports.application'; 

        // Fetch internships and their applications based on the user type
        if ($userType === 'university') {
            // Fetch internships posted by departments within the university or company
            $applications = UserApplication::with('internship')->whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('university_id', Auth::user()->university->id);
            })
                ->where('status', 1)
                ->whereIn('internship_id', function ($query) {
                    $query->select('id')
                        ->from('internships')
                        ->whereDate('start_date', '<', now());
                })
                ->get();
        } else {
            // Fetch internships directly for 'department' or 'udepartment'
            $applications = UserApplication::with('internship')->whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('department_id', Auth::user()->department->id);
            })
                ->where('status', 1)
                ->whereIn('internship_id', function ($query) {
                    $query->select('id')
                        ->from('internships')
                        ->whereDate('start_date', '<', now());
                })
                ->get();
        }
        // Collect all filters from the request
        $filters = $request->all();

        // Validate the request data
        $request->validate([
            'start_date' => 'nullable|date_format:Y-m-d|before:end_date',
            'end_date' => 'nullable|date_format:Y-m-d|after:start_date',
            'date' => 'nullable|in:desc,asc',
        ]);

        // Apply each filter to the applications collection

        if ($request->filled('date')) {
            $applications = $applications->sortBy('created_at', SORT_REGULAR, $request->date === 'desc');
        }

        // Determine if any filters have been activated
        $isFilterActivated = collect($filters)->filter()->isNotEmpty();

        // Return the view with the necessary data
        return view($viewPath, [
            'isFilterActivated' => $isFilterActivated,
            'filters' => $filters,
            'applications' => $applications
        ]);
    }
}
