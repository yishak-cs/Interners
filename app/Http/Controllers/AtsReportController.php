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
        $viewPath = null;

        if ($userType === 'school') {
            $entityId = $user->school->id;
            $entityColumn = 'school_id';
            $viewPath = 'pages.school.reports.application';
        } elseif ($userType === 'company') {
            $entityId = $user->company->id;
            $entityColumn = 'company_id';
            $viewPath = 'pages.company.reports.application';
        } elseif ($userType === 'department') {
            $entityId = $user->department->id;
            $entityColumn = 'department_id';
            $viewPath = 'pages.department.reports.application';
        }elseif ($userType === 'udepartment') {
            $entityId = $user->department->id;
            $entityColumn = 'department_id';
            $viewPath = 'pages.udepartment.reports.application';
        }

        $internships = Internship::where($entityColumn, $entityId)->get();

        $applications = UserApplication::whereIn('internship_id', function ($query) use ($entityColumn, $entityId) {
            $query->select('id')
                ->from('internships')
                ->where($entityColumn, $entityId);
        });

        /**
         * filters array
         *
         * @var array $filters
         */
        $filters = ($request->all()) ? $request->all() : [];
        $request->validate([
            'status' => 'nullable|in:0,1,2',
            'start_date' => 'nullable|date_format:Y-m-d|before:end_date',
            'end_date' => 'nullable|date_format:Y-m-d|after:start_date',
            'internship' => 'nullable|exists:\App\Models\Internship,id',
            'date' => 'nullable|in:desc,asc',
        ]);

        // add filter for status
        if ($request->status != null) {
            $applications = $applications->where('status', $request->status);
        }

        // add filter for internship
        if ($request->internship != null) {
            $applications = $applications->where('internship_id', $request->internship);
        }

        // add filter for start and end date
        if ($request->start_date != null && $request->end_date != null) {
            $applications = $applications->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // add filter for date order
        if ($request->date != null) {
            $applications = $applications->orderBy('created_at', $request->date);
        }

        // get filtered or unfiltered object
        $applications = $applications->get();

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
            $applications = [];
        }

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
        }elseif ($userType === 'udepartment') {
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
