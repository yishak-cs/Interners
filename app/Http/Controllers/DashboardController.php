<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use Illuminate\View\View;
use App\Models\Department;
use App\Models\Internship;
use App\Models\University;
use App\Models\UserApplication;
use App\Models\FacultyDepartment;
use App\Models\EvaluationResponse;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
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
        /**
         * count of department, university, staff and users
         *
         * @var array<string, int> $stat_counts
         */
        $stat_counts = [
            'departments' => count(Department::all()),
            'universities' => count(University::all()),
            'company' => count(Company::all()),
            'staffs' => count(User::where('is_staff', '1')->get()),
            'interns' => count(UserApplication::where('status', '1')->get())
        ];

        /**
         * week dates
         *
         * @var array<string> $week_dates
         */
        $week_dates = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        /**
         * get current week
         *
         * @var \Carbon\Carbon $current_week
         */
        $current_week = Carbon::now()->setTimezone('Africa/Addis_Ababa');

        /**
         * get last week
         *
         * @var \Carbon\Carbon $last_week
         */
        $last_week = Carbon::now()->subWeek()->setTimezone('Africa/Addis_Ababa');

        /**
         * application counts in this week and last week
         *
         * @var array<int <string, int>> $application_count
         */
        $application_count = [
            'thisWeek' => [],
            'lastWeek' => []
        ];

        for ($i = 0; $i < 7; $i++) {
            if ($current_week->startOfWeek()->addDays($i)->isPast()) {
                $application_count['thisWeek'][$week_dates[$i]] = count(UserApplication::whereDate('created_at', $current_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
            }
            $application_count['lastWeek'][$week_dates[$i]] = count(UserApplication::whereDate('created_at', $last_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
        }

        /**
         * calculating Percent increase (or decrease) of applications
         *
         * Percent increase (or decrease) = ((thisWeek - lastWeek)/lastWeek) * 100
         */
        $application_count['percentage'] = (array_sum(array_values($application_count['lastWeek'])) == 0) ? ((array_sum(array_values($application_count['thisWeek'])) == 0) ? 0 : 100) : round(((array_sum(array_values($application_count['thisWeek'])) - array_sum(array_values($application_count['lastWeek']))) / array_sum(array_values($application_count['lastWeek']))) * 100, 2);

        /**
         * all pending applications
         *
         * @var \App\Models\UserApplication $applications
         */
        $applications =  UserApplication::where('status', '0')->get();

        // dd($application_count);
        return view('pages.admin.home', ['applications' => $applications, 'stat_counts' => $stat_counts, 'application_count' => $application_count]);
    }

    /**
     * Display a listing of the resource for university.
     *
     * @return \Illuminate\View\View
     */
    public function universityIndex(): View
    {
        /**
         * count of department, university, staff and users
         *
         * @var array<string, int> $stat_counts
         */
        $stat_counts = [
            'faculties' => count(Department::where('university_id', auth()->user()->university->id)->get()),
            'students' => count(User::where('university_id', auth()->user()->university->id)->get()),
            'departments' => count(FacultyDepartment::whereIn('faculty_id', function ($query){
                $query->select('id')
                ->from('departments')
                ->where('university_id', auth()->user()->university->id);
            })->get()),
            'interning_students' => count(UserApplication::whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->whereIn('university_id', auth()->user()->university);
            })->where('status', '1')->get()),
            'applications' => count(UserApplication::whereIn('internship_id', function ($query) {
                $query->select('id')
                    ->from('internships')
                    ->whereIn('department_id', function ($query2) {
                        $query2->select('id')
                            ->from('departments')
                            ->where('university_id', auth()->user()->university->id);
                    });
            })->get())
        ];

        /**
         * week dates
         *
         * @var array<string> $week_dates
         */
        $week_dates = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        /**
         * get current week
         *
         * @var \Carbon\Carbon $current_week
         */
        $current_week = Carbon::now()->setTimezone('Africa/Addis_Ababa');

        /**
         * get last week
         *
         * @var \Carbon\Carbon $last_week
         */
        $last_week = Carbon::now()->subWeek()->setTimezone('Africa/Addis_Ababa');

        /**
         * application counts in this week and last week
         *
         * @var array<int <string, int>> $application_count
         */
        $pending_application_count = [
            'thisWeek' => [],
            'lastWeek' => []
        ];

        for ($i = 0; $i < 7; $i++) {
            if ($current_week->startOfWeek()->addDays($i)->isPast()) {
                $pending_application_count['thisWeek'][$week_dates[$i]] = count(UserApplication::whereIn('user_id', function ($query) {
                    $query->select('id')
                        ->from('users')
                        ->where('department_id', auth()->user()->university->id);
                })->where('status', '0')
                    ->whereDate('created_at', $current_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
            }
            $pending_application_count['lastWeek'][$week_dates[$i]] = count(UserApplication::whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('department_id', auth()->user()->university->id);
            })->where('status', '0')
                ->whereDate('created_at', $last_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
        }

        /**
         * calculating Percent increase (or decrease) of applications
         *
         * Percent increase (or decrease) = ((thisWeek - lastWeek)/lastWeek) * 100
         */
        $pending_application_count['percentage'] = (array_sum(array_values($pending_application_count['lastWeek'])) == 0) ? ((array_sum(array_values($pending_application_count['thisWeek'])) == 0) ? 0 : 100) : round(((array_sum(array_values($pending_application_count['thisWeek'])) - array_sum(array_values($pending_application_count['lastWeek']))) / array_sum(array_values($pending_application_count['lastWeek']))) * 100, 2);
        
        /**
         * all pending applications
         *
         * @var \App\Models\UserApplication $applications
         */
        $students=User::where('university_id', auth()->user()->university->id)->get();

        // dd($application_count);
        return view('pages.university.home', ['students' => $students, 'stat_counts' => $stat_counts, 'pending_application_count' => $pending_application_count]);
    }
    /**
     * Display a listing of the resource for company.
     *
     * @return \Illuminate\View\View
     */
    public function companyIndex(): View
    {
        /**
         * count of department, company, staff and users
         *
         * @var array<string, int> $stat_counts
         */
        $stat_counts = [
            'departments' => count(Department::where('company_id', auth()->user()->company->id)->get()),
            'internships' => count(Internship::whereIn('department_id', function ($query) {
                $query->select('id')
                    ->from('departments')
                    ->where('company_id', auth()->user()->company->id);
            })->get()),
            'interns' => count(UserApplication::whereIn('internship_id', function ($query) {
                $query->select('id')
                    ->from('internships')
                    ->whereIn('department_id', function ($query2) {
                        $query2->select('id')
                            ->from('departments')
                            ->where('company_id', auth()->user()->company->id);
                    });
            })->where('status', '1')->get()),
            'applications' => count(UserApplication::whereIn('internship_id', function ($query) {
                $query->select('id')
                    ->from('internships')
                    ->whereIn('department_id', function ($query2) {
                        $query2->select('id')
                            ->from('departments')
                            ->where('company_id', auth()->user()->company->id);
                    });
            })->get())
        ];

        /**
         * week dates
         *
         * @var array<string> $week_dates
         */
        $week_dates = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        /**
         * get current week
         *
         * @var \Carbon\Carbon $current_week
         */
        $current_week = Carbon::now()->setTimezone('Africa/Addis_Ababa');

        /**
         * get last week
         *
         * @var \Carbon\Carbon $last_week
         */
        $last_week = Carbon::now()->subWeek()->setTimezone('Africa/Addis_Ababa');

        /**
         * application counts in this week and last week
         *
         * @var array<int <string, int>> $application_count
         */
        $application_count = [
            'thisWeek' => [],
            'lastWeek' => []
        ];

        for ($i = 0; $i < 7; $i++) {
            if ($current_week->startOfWeek()->addDays($i)->isPast()) {
                $application_count['thisWeek'][$week_dates[$i]] = count(UserApplication::whereIn('internship_id', function ($query) {
                    $query->select('id')
                        ->from('internships')
                        ->whereIn('department_id', function ($query2) {
                            $query2->select('id')
                                ->from('departments')
                                ->where('company_id', auth()->user()->company->id);
                        });
                })->whereDate('created_at', $current_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
            }
            $application_count['lastWeek'][$week_dates[$i]] = count(UserApplication::whereIn('internship_id', function ($query) {
                $query->select('id')
                    ->from('internships')
                    ->whereIn('department_id', function ($query2) {
                        $query2->select('id')
                            ->from('departments')
                            ->where('company_id', auth()->user()->company->id);
                    });
            })->whereDate('created_at', $last_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
        }

        /**
         * calculating Percent increase (or decrease) of applications
         *
         * Percent increase (or decrease) = ((thisWeek - lastWeek)/lastWeek) * 100
         */
        $application_count['percentage'] = (array_sum(array_values($application_count['lastWeek'])) == 0) ? ((array_sum(array_values($application_count['thisWeek'])) == 0) ? 0 : 100) : round(((array_sum(array_values($application_count['thisWeek'])) - array_sum(array_values($application_count['lastWeek']))) / array_sum(array_values($application_count['lastWeek']))) * 100, 2);

        /**
         * all pending applications
         *
         * @var \App\Models\UserApplication $applications
         */
        $applications =  UserApplication::whereIn('internship_id', function ($query) {
            $query->select('id')
                ->from('internships')
                ->whereIn('department_id', function ($query2) {
                    $query2->select('id')
                        ->from('departments')
                        ->where('company_id', auth()->user()->company->id);
                });
        })->where('status', '0')->get();

        // dd($application_count);
        return view('pages.company.home', ['applications' => $applications, 'stat_counts' => $stat_counts, 'application_count' => $application_count]);
    }

    /**
     * Display a listing of the resource for department.
     *
     * @return \Illuminate\View\View
     */
    public function departmentIndex(): View
    {
        /**
         * count of department, university, staff and users
         *
         * @var array<string, int> $stat_counts
         */
        $stat_counts = [
            'internships' => count(Internship::where('department_id', auth()->user()->department->id)->get()),
            'applications' => count(UserApplication::whereIn('internship_id', function ($query) {
                $query->select('id')
                    ->from('internships')
                    ->where('department_id', auth()->user()->department->id);
            })->get()),
            'pending' => count(UserApplication::whereIn('internship_id', function ($query) {
                $query->select('id')
                    ->from('internships')
                    ->where('department_id', auth()->user()->department->id);
            })->where('status', '0')->get()),
            'interns' => count(UserApplication::whereIn('internship_id', function ($query) {
                $query->select('id')
                    ->from('internships')
                    ->where('department_id', auth()->user()->department->id);
            })->where('status', '1')->get())
        ];

        /**
         * week dates
         *
         * @var array<string> $week_dates
         */
        $week_dates = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        /**
         * get current week
         *
         * @var \Carbon\Carbon $current_week
         */
        $current_week = Carbon::now()->setTimezone('Africa/Addis_Ababa');

        /**
         * get last week
         *
         * @var \Carbon\Carbon $last_week
         */
        $last_week = Carbon::now()->subWeek()->setTimezone('Africa/Addis_Ababa');

        /**
         * application counts in this week and last week
         *
         * @var array<int <string, int>> $application_count
         */
        $application_count = [
            'thisWeek' => [],
            'lastWeek' => []
        ];

        for ($i = 0; $i < 7; $i++) {
            if ($current_week->startOfWeek()->addDays($i)->isPast()) {
                $application_count['thisWeek'][$week_dates[$i]] = count(UserApplication::whereIn('internship_id', function ($query) {
                    $query->select('id')
                        ->from('internships')
                        ->where('department_id', auth()->user()->department->id);
                })->whereDate('created_at', $current_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
            }
            $application_count['lastWeek'][$week_dates[$i]] = count(UserApplication::whereIn('internship_id', function ($query) {
                $query->select('id')
                    ->from('internships')
                    ->where('department_id', auth()->user()->department->id);
            })->whereDate('created_at', $last_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
        }

        /**
         * calculating Percent increase (or decrease) of applications
         *
         * Percent increase (or decrease) = ((thisWeek - lastWeek)/lastWeek) * 100
         */
        $application_count['percentage'] = (array_sum(array_values($application_count['lastWeek'])) == 0) ? ((array_sum(array_values($application_count['thisWeek'])) == 0) ? 0 : 100) : round(((array_sum(array_values($application_count['thisWeek'])) - array_sum(array_values($application_count['lastWeek']))) / array_sum(array_values($application_count['lastWeek']))) * 100, 2);

        /**
         * all pending applications
         *
         * @var \App\Models\UserApplication $applications
         */
        $applications =  UserApplication::whereIn('internship_id', function ($query) {
            $query->select('id')
                ->from('internships')
                ->where('department_id', auth()->user()->department->id);
        })->where('status', '0')->get();

        // dd($application_count);
        return view('pages.' . $this->current_route . '.home', ['applications' => $applications, 'stat_counts' => $stat_counts, 'application_count' => $application_count]);
    }

    /**
     * Display a listing of the resource for a faculty.
     *
     * @return \Illuminate\View\View
     */
    public function facultyIndex(): View
    {
        /**
         * count of department, student and 
         *
         * @var array<string, int> $stat_counts
         */
        $stat_counts = [
            'Students' => count(User::where('department_id', auth()->user()->department->id)->get()),
            'Faculty_departments' => count(FacultyDepartment::where('faculty_id', auth()->user()->department->id)->get()),
            'Evaluation_response' => count(EvaluationResponse::whereIn('evaluation_id', function ($query) {
                $query->select('id')
                    ->from('evaluations')
                    ->where('department_id', auth()->user()->department->id);
            })->get()),
            'Accepted' => count(UserApplication::whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('department_id', auth()->user()->department->id);
            })->where('status', '1')->get()),

            'Pending' => count(UserApplication::whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('department_id', auth()->user()->department->id);
            })->where('status', '0')->get())

        ];

        /**
         * week dates
         *
         * @var array<string> $week_dates
         */
        $week_dates = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        /**
         * get current week
         *
         * @var \Carbon\Carbon $current_week
         */
        $current_week = Carbon::now()->setTimezone('Africa/Addis_Ababa');

        /**
         * get last week
         *
         * @var \Carbon\Carbon $last_week
         */
        $last_week = Carbon::now()->subWeek()->setTimezone('Africa/Addis_Ababa');

        /**
         * pending application counts in this week and last week
         *
         * @var array<int <string, int>> $pending_application_count
         */
        $pending_application_count = [
            'thisWeek' => [],
            'lastWeek' => []
        ];

        for ($i = 0; $i < 7; $i++) {
            if ($current_week->startOfWeek()->addDays($i)->isPast()) {
                $pending_application_count['thisWeek'][$week_dates[$i]] = count(UserApplication::whereIn('user_id', function ($query) {
                    $query->select('id')
                        ->from('users')
                        ->where('department_id', auth()->user()->department->id);
                })->where('status', '0')
                    ->whereDate('created_at', $current_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
            }
            $pending_application_count['lastWeek'][$week_dates[$i]] = count(UserApplication::whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('department_id', auth()->user()->department->id);
            })->where('status', '0')
                ->whereDate('created_at', $last_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
        }

        /**
         * application response counts in this week and last week
         *
         * @var array<int <string, int>> $pending_application_count
         */
        $application_response_count = [
            'thisWeek' => [],
            'lastWeek' => []
        ];

        for ($i = 0; $i < 7; $i++) {
            if ($current_week->startOfWeek()->addDays($i)->isPast()) {
                $application_response_count['thisWeek'][$week_dates[$i]] = count(EvaluationResponse::whereIn('evaluation_id', function ($query) {
                    $query->select('id')
                        ->from('evaluations')
                        ->where('department_id', auth()->user()->department->id);
                })
                    ->whereDate('created_at', $current_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
            }
            $application_response_count['lastWeek'][$week_dates[$i]] =  count(EvaluationResponse::whereIn('evaluation_id', function ($query) {
                $query->select('id')
                    ->from('evaluations')
                    ->where('department_id', auth()->user()->department->id);
            })
                ->whereDate('created_at', $last_week->startOfWeek()->addDays($i)->format('Y-m-d H:i:s'))->get());
        }
        /**
         * calculating Percent increase (or decrease) of applications
         *
         * Percent increase (or decrease) = ((thisWeek - lastWeek)/lastWeek) * 100
         */
        $pending_application_count['percentage'] = (array_sum(array_values($pending_application_count['lastWeek'])) == 0) ? ((array_sum(array_values($pending_application_count['thisWeek'])) == 0) ? 0 : 100) : round(((array_sum(array_values($pending_application_count['thisWeek'])) - array_sum(array_values($pending_application_count['lastWeek']))) / array_sum(array_values($pending_application_count['lastWeek']))) * 100, 2);

        /**
         * calculating Percent increase (or decrease) of application_response
         *
         * Percent increase (or decrease) = ((thisWeek - lastWeek)/lastWeek) * 100
         */
        $application_response_count['percentage'] = (array_sum(array_values($application_response_count['lastWeek'])) == 0) ? ((array_sum(array_values($application_response_count['thisWeek'])) == 0) ? 0 : 100) : round(((array_sum(array_values($application_response_count['thisWeek'])) - array_sum(array_values($application_response_count['lastWeek']))) / array_sum(array_values($application_response_count['lastWeek']))) * 100, 2);


        // dd($pending_application_count);
        return view('pages.' . $this->current_route . '.home', ['stat_counts' => $stat_counts, 'pending_application_count' => $pending_application_count, 'application_response_count' => $application_response_count]);
    }
}
