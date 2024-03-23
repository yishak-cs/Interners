<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\UserApplication;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AtsReportController extends Controller
{
    /**
     * Application listing for school, company, or department.
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
        if ($userType === 'school') {
            $entityId = $user->school->id;
            $entityColumn = 'school_id';
        } elseif ($userType === 'company') {
            $entityId = $user->company->id;
            $entityColumn = 'company_id';
        } elseif ($userType === 'department' || $userType === 'udepartment') {
            $entityId = $user->department->id;
            $entityColumn = 'department_id';
        }

        // Fetch internships and their applications based on the user type
        if ($userType === 'school' || $userType === 'company') {
            // Fetch internships posted by departments within the school or company
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
     * Internship listing for school, company, or department.
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
        $viewPath = null;

        if ($userType === 'school') {
            $entityId = $user->school->id;
            $entityColumn = 'school_id';
            $viewPath = 'pages.school.reports.internship';
        } elseif ($userType === 'company') {
            $entityId = $user->company->id;
            $entityColumn = 'company_id';
            $viewPath = 'pages.company.reports.internship';
        } elseif ($userType === 'department') {
            $entityId = $user->department->id;
            $entityColumn = 'department_id';
            $viewPath = 'pages.department.reports.internship';
        } elseif ($userType === 'udepartment') {
            $entityId = $user->department->id;
            $entityColumn = 'department_id';
            $viewPath = 'pages.udepartment.reports.internship';
        }

        if ($userType === 'school' || $userType === 'company') {
            $internships = Internship::whereIn('department_id', function ($query) use ($entityColumn, $entityId) {
                $query->select('id')
                    ->from('departments')
                    ->where($entityColumn, $entityId);
            });
        } else {
            $internships = Internship::where('department_id', $entityId);
        }

        /**
         * filters array
         *
         * @var array $filters
         */
        $filters = ($request->all()) ? $request->all() : [];
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

        // get filtered or unfiltered object
        $internships = $internships->get();

        /**
         * check if filter is applied
         *
         * @var bool $isFilterActivated
         */
        $isFilterActivated = false;
        if (count($filters) > 0) {
            foreach ($filters as $key => $filter) {
                if ($filter != null) $isFilterActivated = true;
            }
        }

        if (!$isFilterActivated) {
            $internships = [];
        }

        return view($viewPath, [
            'isFilterActivated' => $isFilterActivated,
            'filters' => $filters,
            'internships' => $internships,
        ]);
    }
}
