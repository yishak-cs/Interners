<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AtsReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\MessageRoomController;
use App\Http\Controllers\SDepartmentController;
use App\Http\Controllers\UserApplicationController;
use App\Http\Controllers\UserInformationController;

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

        // admin/school routes
        Route::prefix('/school')->group(function () {
            Route::get('/add', [SchoolController::class, 'create'])->name('admin.school.add');
            Route::post('/add', [SchoolController::class, 'store'])->name('admin.school.store');
            Route::get('/list', [SchoolController::class, 'index'])->name('admin.school.list');
            Route::get('/view/{school}', [SchoolController::class, 'show'])->name('admin.school.view');
            Route::get('/edit/{school}', [SchoolController::class, 'edit'])->name('admin.school.edit');
            Route::post('/update/{school}', [SchoolController::class, 'update'])->name('admin.school.update');
            Route::get('/delete/{school}', [SchoolController::class, 'destroy'])->name('admin.school.delete');
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

/** School Department Route Start */
Route::middleware(['auth', 'verified', 'user-access:udepartment'])->group(function () {
    Route::prefix('/udepartment')->group(function () {
        Route::get('/home', [DashboardController::class, 'departmentIndex'])->name('udepartment.home');

        // School department/internship routes
        Route::prefix('/internship')->group(function () {
            Route::get('/add', [InternshipController::class, 'create'])->name('udepartment.internship.add');
            Route::post('/add', [InternshipController::class, 'store'])->name('udepartment.internship.store');
            Route::get('/list', [InternshipController::class, 'departmentIndex'])->name('udepartment.internship.list');
            Route::get('/view/{internship}', [InternshipController::class, 'show'])->name('udepartment.internship.view');
            Route::get('/edit/{internship}', [InternshipController::class, 'edit'])->name('udepartment.internship.edit');
            Route::post('/update/{internship}', [InternshipController::class, 'update'])->name('udepartment.internship.update');
            Route::post('/updatepre/{internship}', [InternshipController::class, 'updatePrerequisite'])->name('udepartment.internship.updatePre');
            Route::get('/delete/{internship}', [InternshipController::class, 'destroy'])->name('udepartment.internship.delete');
            Route::get('/start/{internship}', [InternshipController::class, 'start'])->name('udepartment.internship.start');
        });

        // School department/application route
        Route::prefix('/application')->group(function () {
            Route::get('/list', [UserApplicationController::class, 'departmentIndex'])->name('udepartment.application.list');
            Route::get('/view/{userapplication}', [UserApplicationController::class, 'show'])->name('udepartment.application.view');
            Route::get('/accept/{userapplication}', [UserApplicationController::class, 'acceptApplication'])->name('udepartment.application.accept');
            Route::get('/reject/{userapplication}', [UserApplicationController::class, 'rejectApplication'])->name('udepartment.application.reject');
            Route::get('/reset/{userapplication}', [UserApplicationController::class, 'resetApplication'])->name('udepartment.application.reset');
            Route::get('/delete/{userapplication}', [UserApplicationController::class, 'destroy'])->name('udepartment.application.delete');
            Route::get('/filter', [UserApplicationController::class, 'filter'])->name('udepartment.application.filter');
        });

        // School department/profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [UserController::class, 'profile'])->name('udepartment.profile');
            Route::post('/setting', [UserInformationController::class, 'store'])->name('udepartment.profile.setting');
            Route::post('/password/{user}', [UserController::class, 'passwordChange'])->name('udepartment.profile.password');
        });

        // school department/intern routes
        Route::prefix('/intern')->group(function () {
            Route::get('/list', [InternController::class, 'departmentIndex'])->name('udepartment.intern.list');
            Route::get('/view/{intern}', [InternController::class, 'show'])->name('udepartment.intern.view');
            Route::get('/delete/{intern}', [InternController::class, 'destroy'])->name('udepartment.intern.delete');
        });

        // school department/students routes
        Route::prefix('/students')->group(function () {
            Route::get('/list', [StudentController::class, 'index'])->name('udepartment.student.list');
            Route::get('/view/{student}', [StudentController::class, 'show'])->name('udepartment.student.view');
            Route::get('/delete/{student}', [StudentController::class, 'destroy'])->name('udepartment.student.delete');
        });

        // School department/reports route
        Route::prefix('/reports')->group(function () {
            Route::get('/application', [AtsReportController::class, 'applicationListing'])->name('udepartment.reports.application');
            Route::get('/internship', [AtsReportController::class, 'internshipListing'])->name('udepartment.reports.internship');
        });
    });
});
/** School Department Route End */


/** School Route Start */
Route::middleware(['auth', 'verified', 'user-access:school'])->group(function () {
    Route::prefix('/school')->group(function () {
        Route::get('/home', [DashboardController::class, 'schoolIndex'])->name('school.home');

        // school/department routes
        Route::prefix('/department')->group(function () {
            Route::get('/add', [SDepartmentController::class, 'create'])->name('school.department.add');
            Route::post('/add', [SDepartmentController::class, 'store'])->name('school.department.store');
            Route::get('/list', [SDepartmentController::class, 'schoolIndex'])->name('school.department.list');
            Route::get('/view/{department}', [SDepartmentController::class, 'show'])->name('school.department.view');
            Route::get('/edit/{department}', [SDepartmentController::class, 'edit'])->name('school.department.edit');
            Route::post('/update/{department}', [SDepartmentController::class, 'update'])->name('school.department.update');
            Route::get('/delete/{department}', [SDepartmentController::class, 'destroy'])->name('school.department.delete');
        });

        // school/internship route
        Route::prefix('/internship')->group(function () {
            Route::get('/list', [InternshipController::class, 'schoolIndex'])->name('school.internship.list');
            Route::get('/view/{internship}', [InternshipController::class, 'show'])->name('school.internship.view');
            Route::get('/start/{internship}', [InternshipController::class, 'start'])->name('school.internship.start');
            Route::get('/delete/{internship}', [InternshipController::class, 'destroy'])->name('school.internship.delete');
        });

        // school/application route
        Route::prefix('/application')->group(function () {
            Route::get('/list', [UserApplicationController::class, 'schoolIndex'])->name('school.application.list');
            Route::get('/delete/{userapplication}', [UserApplicationController::class, 'destroy'])->name('school.application.delete');
        });

        // school/profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [UserController::class, 'profile'])->name('school.profile');
            Route::post('/setting', [UserInformationController::class, 'store'])->name('school.profile.setting');
            Route::post('/password/{user}', [UserController::class, 'passwordChange'])->name('school.profile.password');
        });

        // school/intern routes
        Route::prefix('/intern')->group(function () {
            Route::get('/list', [InternController::class, 'schoolIndex'])->name('school.intern.list');
            Route::get('/view/{intern}', [InternController::class, 'show'])->name('school.intern.view');
        });

        // school/reports route
        Route::prefix('/reports')->group(function () {
            Route::get('/application', [AtsReportController::class, 'applicationListing'])->name('school.reports.application');
            Route::get('/internship', [AtsReportController::class, 'internshipListing'])->name('school.reports.internship');
        });
        // school/staff routes
        Route::prefix('/staff')->group(function () {
            Route::get('/add', [UserController::class, 'staffCreate'])->name('school.staff.add');
            Route::post('/add', [UserController::class, 'staffStore'])->name('school.staff.store');
            Route::get('/list', [UserController::class, 'staffIndex'])->name('school.staff.list');
            Route::get('/view/{user}', [UserController::class, 'staffShow'])->name('school.staff.view');
            Route::get('/edit/{user}', [UserController::class, 'staffEdit'])->name('school.staff.edit');
            Route::post('/update/{user}', [UserController::class, 'staffUpdate'])->name('school.staff.update');
            Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('school.staff.delete');
        });
    });
});
/** School Route End */

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
            Route::get('/get-departments/{schoolId}', [SchoolController::class, 'getDepartments'])->name('user.get-departments');
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
