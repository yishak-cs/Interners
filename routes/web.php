<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AtsReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserApplicationController;
use App\Http\Controllers\UserInformationController;
use App\Http\Controllers\FacultyDepartmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Auth::routes(['verify' => true]);

/** Admin Route Start */
Route::middleware(['auth', 'verified', 'user-access:admin'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/home', [DashboardController::class, 'index'])->name('admin.home');

        // admin/university routes
        Route::prefix('/university')->group(function () {
            Route::get('/add', [UniversityController::class, 'create'])->name('admin.university.add');
            Route::post('/add', [UniversityController::class, 'store'])->name('admin.university.store');
            Route::get('/list', [UniversityController::class, 'index'])->name('admin.university.list');
            Route::get('/view/{university}', [UniversityController::class, 'show'])->name('admin.university.view');
            Route::get('/edit/{university}', [UniversityController::class, 'edit'])->name('admin.university.edit');
            Route::post('/update/{university}', [UniversityController::class, 'update'])->name('admin.university.update');
            Route::get('/delete/{university}', [UniversityController::class, 'destroy'])->name('admin.university.delete');
        });
        // admin/company routes
        Route::prefix('/company')->group(function () {
            Route::get('/add', [CompanyController::class, 'create'])->name('admin.company.add');
            Route::post('/add', [CompanyController::class, 'store'])->name('admin.company.store');
            Route::get('/list', [CompanyController::class, 'index'])->name('admin.company.list');
            Route::get('/view/{company}', [CompanyController::class, 'show'])->name('admin.company.view');
            Route::get('/edit/{company}', [CompanyController::class, 'edit'])->name('admin.company.edit');
            Route::post('/update/{company}', [CompanyController::class, 'update'])->name('admin.company.update');
            Route::get('/delete/{company}', [CompanyController::class, 'destroy'])->name('admin.company.delete');
        });

        // admin/department routes nebere

        // admin/staff routes
        Route::prefix('/staff')->group(function () {
            Route::get('/add', [UserController::class, 'staffCreate'])->name('admin.staff.add');
            Route::post('/add', [UserController::class, 'staffStore'])->name('admin.staff.store');
            Route::get('/list', [UserController::class, 'staffIndex'])->name('admin.staff.list');
            Route::get('/view/{user}', [UserController::class, 'staffShow'])->name('admin.staff.view');
            Route::get('/edit/{user}', [UserController::class, 'staffEdit'])->name('admin.staff.edit');
            Route::post('/update/{user}', [UserController::class, 'staffUpdate'])->name('admin.staff.update');
            Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('admin.staff.delete');
        });

        // admin/internship route neber


        // admin/application route neber


        // admin/profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [UserController::class, 'profile'])->name('admin.profile');
            Route::post('/setting', [UserInformationController::class, 'store'])->name('admin.profile.setting');
            Route::post('/password/{user}', [UserController::class, 'passwordChange'])->name('admin.profile.password');
        });

        // admin/intern routes neber


        // admin/reports route neber


    });
});
/** Admin Route End */

/** Department Route Start */
Route::middleware(['auth', 'verified', 'user-access:department'])->group(function () {
    Route::prefix('/department')->group(function () {
        Route::get('/home', [DashboardController::class, 'departmentIndex'])->name('department.home');

        // department/internship routes
        Route::prefix('/internship')->group(function () {
            Route::get('/add', [InternshipController::class, 'create'])->name('department.internship.add');
            Route::post('/add', [InternshipController::class, 'store'])->name('department.internship.store');
            Route::get('/list', [InternshipController::class, 'departmentIndex'])->name('department.internship.list');
            Route::get('/view/{internship}', [InternshipController::class, 'show'])->name('department.internship.view');
            Route::get('/edit/{internship}', [InternshipController::class, 'edit'])->name('department.internship.edit');
            Route::post('/update/{internship}', [InternshipController::class, 'update'])->name('department.internship.update');
            Route::post('/updatepre/{internship}', [InternshipController::class, 'updatePrerequisite'])->name('department.internship.updatePre');
            Route::get('/delete/{internship}', [InternshipController::class, 'destroy'])->name('department.internship.delete');
            Route::get('/start/{internship}', [InternshipController::class, 'start'])->name('department.internship.start');
        });

        // department/application route
        Route::prefix('/application')->group(function () {
            Route::get('/list', [UserApplicationController::class, 'departmentIndex'])->name('department.application.list');
            Route::get('/view/{userapplication}', [UserApplicationController::class, 'show'])->name('department.application.view');
            Route::get('/accept/{userapplication}', [UserApplicationController::class, 'acceptApplication'])->name('department.application.accept');
            Route::get('/reject/{userapplication}', [UserApplicationController::class, 'rejectApplication'])->name('department.application.reject');
            Route::get('/reset/{userapplication}', [UserApplicationController::class, 'resetApplication'])->name('department.application.reset');
            Route::get('/delete/{userapplication}', [UserApplicationController::class, 'destroy'])->name('department.application.delete');
            Route::get('/filter', [UserApplicationController::class, 'filter'])->name('department.application.filter');
        });

        // department/profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [UserController::class, 'profile'])->name('department.profile');
            Route::post('/setting', [UserInformationController::class, 'store'])->name('department.profile.setting');
            Route::post('/password/{user}', [UserController::class, 'passwordChange'])->name('department.profile.password');
        });

        // department/intern routes
        Route::prefix('/intern')->group(function () {
            Route::get('/list', [InternController::class, 'departmentIndex'])->name('department.intern.list');
            Route::get('/view/{intern}', [InternController::class, 'show'])->name('department.intern.view');
            Route::get('/delete/{intern}', [InternController::class, 'destroy'])->name('department.intern.delete');
        });
        // department/reports route
        Route::prefix('/reports')->group(function () {
            Route::get('/application', [AtsReportController::class, 'applicationListing'])->name('department.reports.application');
            Route::get('/internship', [AtsReportController::class, 'internshipListing'])->name('department.reports.internship');
        });
    });
});
/** Department Route End */

/** faculty Route Start */
Route::middleware(['auth', 'verified', 'user-access:faculty'])->group(function () {
    Route::prefix('/faculty')->group(function () {
        Route::get('/home', [DashboardController::class, 'facultyIndex'])->name('faculty.home');

        // faculty/internship routes used to be here


        // faculty/department routes
        Route::prefix('/department')->group(function () {
            Route::get('/add', [FacultyDepartmentController::class, 'create'])->name('faculty.department.add');
            Route::post('/add', [FacultyDepartmentController::class, 'store'])->name('faculty.department.store');
            Route::get('/list', [FacultyDepartmentController::class, 'index'])->name('faculty.department.list');
            Route::get('/view/{faculty_department}', [FacultyDepartmentController::class, 'show'])->name('faculty.department.view');
            Route::get('/edit/{faculty_department}', [FacultyDepartmentController::class, 'edit'])->name('faculty.department.edit');
            Route::post('/update/{faculty_department}', [FacultyDepartmentController::class, 'update'])->name('faculty.department.update');
            Route::get('/delete/{faculty_department}', [FacultyDepartmentController::class, 'destroy'])->name('faculty.department.delete');
        });

        // faculty/application route was here


        // faculty/profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [UserController::class, 'profile'])->name('faculty.profile');
            Route::post('/setting', [UserInformationController::class, 'store'])->name('faculty.profile.setting');
            Route::post('/password/{user}', [UserController::class, 'passwordChange'])->name('faculty.profile.password');
        });

        // faculty/students routes
        Route::prefix('/students')->group(function () {
            Route::get('/list', [StudentController::class, 'index'])->name('faculty.student.list');
            Route::get('/view/{student}', [StudentController::class, 'show'])->name('faculty.student.view');
            Route::get('/delete/{student}', [StudentController::class, 'destroy'])->name('faculty.student.delete');
        });

        // faculty/reports route
        Route::prefix('/reports')->group(function () {
            Route::get('/application', [AtsReportController::class, 'applicationListing'])->name('faculty.reports.application');
            Route::get('/internship', [AtsReportController::class, 'internshipListing'])->name('faculty.reports.internship');
        });
        // faculty/evaluation route
        Route::prefix('/evaluations')->group(function () {
            Route::get('/add', function () {
                return view('pages.faculty.evaluation.add');
            })->name('faculty.evaluation.add');
            Route::Post('/add', [EvaluationController::class, 'store'])->name('faculty.evaluation.store');
            Route::get('/list', [EvaluationController::class, 'index'])->name('faculty.evaluation.list');
            Route::get('/view/{evaluation}', [EvaluationController::class, 'show'])->name('faculty.evaluation.view');
            Route::get('/delete/{evaluation}', [EvaluationController::class, 'destroy'])->name('faculty.evaluation.delete');
            Route::post('/update/status/{evaluation}', [EvaluationController::class, 'updateStatus'])->name('faculty.evaluation.update.status');

            // under construction
            Route::get('/send/{evaluation}', [EvaluationController::class, 'send'])->name('faculty.evaluation.send');
        });
    });
});
/** faculty Route End */


/** university Route Start */
Route::middleware(['auth', 'verified', 'user-access:university'])->group(function () {
    Route::prefix('/university')->group(function () {
        Route::get('/home', [DashboardController::class, 'universityIndex'])->name('university.home');

        // university/faculty routes
        Route::prefix('/faculty')->group(function () {
            Route::get('/add', [FacultyController::class, 'create'])->name('university.faculty.add');
            Route::post('/add', [FacultyController::class, 'store'])->name('university.faculty.store');
            Route::get('/list', [FacultyController::class, 'universityIndex'])->name('university.faculty.list');
            Route::get('/view/{faculty}', [FacultyController::class, 'show'])->name('university.faculty.view');
            Route::get('/edit/{faculty}', [FacultyController::class, 'edit'])->name('university.faculty.edit');
            Route::post('/update/{faculty}', [FacultyController::class, 'update'])->name('university.faculty.update');
            Route::get('/delete/{faculty}', [FacultyController::class, 'destroy'])->name('university.faculty.delete');
        });

        // university/internship route was here

        // university/application route was here

        // university/profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [UserController::class, 'profile'])->name('university.profile');
            Route::post('/setting', [UserInformationController::class, 'store'])->name('university.profile.setting');
            Route::post('/password/{user}', [UserController::class, 'passwordChange'])->name('university.profile.password');
        });

        // university/reports route
        Route::prefix('/reports')->group(function () {
            Route::get('/application', [AtsReportController::class, 'applicationListing'])->name('university.reports.application');
            Route::get('/internship', [AtsReportController::class, 'internshipListing'])->name('university.reports.internship');
        });
        // university/staff routes
        Route::prefix('/staff')->group(function () {
            Route::get('/add', [UserController::class, 'staffCreate'])->name('university.staff.add');
            Route::post('/add', [UserController::class, 'staffStore'])->name('university.staff.store');
            Route::get('/list', [UserController::class, 'staffIndex'])->name('university.staff.list');
            Route::get('/view/{user}', [UserController::class, 'staffShow'])->name('university.staff.view');
            Route::get('/edit/{user}', [UserController::class, 'staffEdit'])->name('university.staff.edit');
            Route::post('/update/{user}', [UserController::class, 'staffUpdate'])->name('university.staff.update');
            Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('university.staff.delete');
        });
    });
});
/** University Route End */

/** Company Route Start */
Route::middleware(['auth', 'verified', 'user-access:company'])->group(function () {
    Route::prefix('/company')->group(function () {
        Route::get('/home', [DashboardController::class, 'companyIndex'])->name('company.home');

        // company/department routes
        Route::prefix('/department')->group(function () {
            Route::get('/add', [DepartmentController::class, 'create'])->name('company.department.add');
            Route::post('/add', [DepartmentController::class, 'store'])->name('company.department.store');
            Route::get('/list', [DepartmentController::class, 'companyIndex'])->name('company.department.list');
            Route::get('/view/{department}', [DepartmentController::class, 'show'])->name('company.department.view');
            Route::get('/edit/{department}', [DepartmentController::class, 'edit'])->name('company.department.edit');
            Route::post('/update/{department}', [DepartmentController::class, 'update'])->name('company.department.update');
            Route::get('/delete/{department}', [DepartmentController::class, 'destroy'])->name('company.department.delete');
        });

        // company/internship route
        Route::prefix('/internship')->group(function () {
            Route::get('/list', [InternshipController::class, 'companyIndex'])->name('company.internship.list');
            Route::get('/view/{internship}', [InternshipController::class, 'show'])->name('company.internship.view');
            Route::get('/start/{internship}', [InternshipController::class, 'start'])->name('company.internship.start');
            Route::get('/delete/{internship}', [InternshipController::class, 'destroy'])->name('company.internship.delete');
        });

        // company/application route
        Route::prefix('/application')->group(function () {
            Route::get('/list', [UserApplicationController::class, 'companyIndex'])->name('company.application.list');
            Route::get('/delete/{userapplication}', [UserApplicationController::class, 'destroy'])->name('company.application.delete');
        });

        // company/profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [UserController::class, 'profile'])->name('company.profile');
            Route::post('/setting', [UserInformationController::class, 'store'])->name('company.profile.setting');
            Route::post('/password/{user}', [UserController::class, 'passwordChange'])->name('company.profile.password');
        });

        // company/intern routes
        Route::prefix('/intern')->group(function () {
            Route::get('/list', [InternController::class, 'companyIndex'])->name('company.intern.list');
            Route::get('/view/{intern}', [InternController::class, 'show'])->name('company.intern.view');
        });

        // company/reports route
        Route::prefix('/reports')->group(function () {
            Route::get('/application', [AtsReportController::class, 'applicationListing'])->name('company.reports.application');
            Route::get('/internship', [AtsReportController::class, 'internshipListing'])->name('company.reports.internship');
        });
        // company/staff routes
        Route::prefix('/staff')->group(function () {
            Route::get('/add', [UserController::class, 'staffCreate'])->name('company.staff.add');
            Route::post('/add', [UserController::class, 'staffStore'])->name('company.staff.store');
            Route::get('/list', [UserController::class, 'staffIndex'])->name('company.staff.list');
            Route::get('/view/{user}', [UserController::class, 'staffShow'])->name('company.staff.view');
            Route::get('/edit/{user}', [UserController::class, 'staffEdit'])->name('company.staff.edit');
            Route::post('/update/{user}', [UserController::class, 'staffUpdate'])->name('company.staff.update');
            Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('company.staff.delete');
        });
    });
});
/** company Route End */

/** User Route Start */
Route::middleware(['auth', 'verified', 'user-access:user'])->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/home', [HomeController::class, 'usersHome'])->name('user.home');

        // user/internship routes
        Route::prefix('/internship')->group(function () {
            Route::get('/view/{internship}', [InternshipController::class, 'show'])->name('user.internship.view');
            Route::get('/apply/{internship}', [UserApplicationController::class, 'create'])->name('user.internship.apply');
            Route::post('/apply/{internship}', [UserApplicationController::class, 'store'])->name('user.internship.store');
        });
        // user/profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [UserController::class, 'profile'])->name('user.profile');
            Route::get('/setting', [UserController::class, 'profileSettings'])->name('user.profile.settings');
            Route::post('/setting/{user}', [UserInformationController::class, 'store'])->name('user.profile.setting');
            Route::post('/password/{user}', [UserController::class, 'passwordChange'])->name('user.profile.password');
            Route::post('/upload', [UserInformationController::class, 'upload'])->name('user.profile.upload');
            Route::get('/get-departments/{universityId}', [UniversityController::class, 'getDepartments'])->name('user.get-departments');
            Route::get('/get-facultydepartments/{facultyId}', [FacultyController::class, 'getFacultyDepartments'])->name('user.get-FacultyDepartments');
        });

        // user/application routes
        Route::prefix('/application')->group(function () {
            Route::get('/list', [UserApplicationController::class, 'userIndex'])->name('user.application.list');
            Route::get('/delete/{userapplication}', [UserApplicationController::class, 'revoke'])->name('user.application.delete');
        });
    });
});
/** User Route End */



Route::get('/start', function () {
    return view('email.start');
});
