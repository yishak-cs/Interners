<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Evaluation;
use App\Models\FacultyDepartment;
use App\Models\Internship;
use App\Models\User;
use App\Models\UserApplication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public const MODEL_DEPARTMENT = 'department';
    public const MODEL_USER = 'user';
    public const MODEL_INTERNSHIP = 'internship';
    public const MODEL_UNIVERSITY = 'university';
    public const MODEL_COMPANY = 'company';
    public const MODEL_APPLICATIONS = 'applications';
    public const MODEL_INTERNS = 'interns';
    public const MODEL_STUDENTS = 'students';
    public const MODEL_STAFF = 'staff';
    public const MODEL_EVALUATION = 'evaluation';

    public const ACTION_VIEW = 'view';
    public const ACTION_EDIT = 'edit';
    public const ACTION_UPDATE = 'update';
    public const ACTION_CREATE = 'create';
    public const ACTION_STORE = 'store';
    public const ACTION_DELETE = 'delete';
    public const ACTION_ACCEPT_APPLICATION = 'accept_application';
    public const ACTION_REJECT_APPLICATION = 'reject_application';
    public const ACTION_RESET_APPLICATION = 'reset_application';
    public const ACTION_APPLY = 'apply';


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * check authorizations for various actions
     *
     * @param string $model
     * @param string $actor
     * @param string $action
     * @param mixed $data
     * @return bool
     */
    public function checkAuthorizations(string $model, string $actor, mixed $data, string $action): bool
    {
        // check for required fields
        if ($model == null || $actor == null || $data == null) return false;
        if ($model == '' || $actor == '' || $data == '') return false;

        switch ($actor) {
            case 'admin':
                return $this->checkAdminAuthorizations($model, $data, $action);
            case 'user':
                return $this->checkUserAuthorizations($model, $data, $action);
            case 'department':
                return $this->checkDepartmentAuthorizations($model, $data, $action);
            case 'university':
                return $this->checkUniversityAuthorizations($model, $data, $action);
            case 'company':
                return $this->checkCompanyAuthorizations($model, $data, $action);
            case 'faculty':
                return $this->checkfacultyAuthorizations($model, $data, $action);
            default:
                // unknown actor
                return false;
        }
    }


    /**
     * check university authorizations
     *
     * @param string $model
     * @param string $action
     * @param mixed $data
     * @return bool
     */
    public function checkAdminAuthorizations(string $model, mixed $data, string $action = null): bool
    {
        // check if the user is Admin of department
        if (auth()->user()->type != 'admin') return false;
        // dd($data);

        // check for university actions
        if ($model === self::MODEL_UNIVERSITY) {
            return true;
        }
        // check for company actions
        if ($model === self::MODEL_COMPANY) {
            return true;
        }
        // check for department
        else if ($model === self::MODEL_DEPARTMENT) {
            return true;
        }
        // check for staffs actions
        else if ($model === self::MODEL_STAFF) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof User)) return false;

            // check if the user is staff
            if ($data->is_staff == '1') {
                return true;
            } else {
                return false;
            }
        }
        // check for internship actions
        else if ($model === self::MODEL_INTERNSHIP) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof Internship)) return false;

            // check the action
            if ($action === self::ACTION_VIEW || $action === self::ACTION_DELETE) {
                return true;
            } else {
                return false;
            }
        }
        // check for application actions
        else if ($model === self::MODEL_APPLICATIONS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check the action
            if ($action === self::ACTION_DELETE) {
                return true;
            } else {
                return false;
            }
        }
        // check for interns actions
        else if ($model === self::MODEL_INTERNS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check the action
            if ($action === self::ACTION_VIEW) {
                return true;
            } else {
                return false;
            }
        }
        // if other models comes it doesn't have authorization
        else {
            return false;
        }
        return true;
    }

    /**
     * check university authorizations
     *
     * @param string $model
     * @param string $action
     * @param mixed $data
     * @return bool
     */
    public function checkUniversityAuthorizations(string $model, mixed $data, string $action = null): bool
    {
        // check if the user is Admin of university
        if (auth()->user()->university === null) return false;
        // check for department actions
        if ($model === self::MODEL_DEPARTMENT) {
            // check the instance
            if (!($data instanceof Department)) return false;

            // check if the user owns the department
            if ($data->university_id === auth()->user()->university->id) {
                return true;
            } else {
                return false;
            }
        }
        // check for internship actions
        else if ($model === self::MODEL_INTERNSHIP) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof Internship)) return false;

            // check if the user owns the internship
            if ($data->department->university->id === auth()->user()->university->id) {
                // check the action
                if ($action === self::ACTION_VIEW || $action === self::ACTION_DELETE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // check for application actions
        else if ($model === self::MODEL_APPLICATIONS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check if the user owns the application
            if ($data->internship->department->university->id === auth()->user()->university->id) {
                // check the action
                if ($action === self::ACTION_DELETE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // check for staffs actions
        else if ($model === self::MODEL_STAFF) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof User)) return false;

            // check if the user is staff
            if ($data->is_staff == '3') {
                return true;
            } else {
                return false;
            }
        }

        // check for interns actions
        else if ($model === self::MODEL_INTERNS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check if the user owns the interns
            if ($data->internship->department->university->id === auth()->user()->university->id) {
                // check the action
                if ($action === self::ACTION_VIEW) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // if other models comes it doesn't have authorization
        else {
            return false;
        }
    }

    /**
     * check department authorizations
     *
     * @param string $model
     * @param string $action
     * @param mixed $data
     * @return bool
     */
    public function checkDepartmentAuthorizations(string $model, mixed $data, string $action = null): bool
    {
        // check if the user is Admin of department
        if (auth()->user()->department === null) return false;

        // check for department actions
        if ($model === self::MODEL_INTERNSHIP) {
            // check the instance
            if (!($data instanceof Internship)) return false;


            // check if the user owns the department
            if ($data->department_id === auth()->user()->department->id) {
                return true;
            } else {
                return false;
            }
        }

        // check for application actions
        else if ($model === self::MODEL_APPLICATIONS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check if the user owns the application
            if ($data->internship->department->id === auth()->user()->department->id) {
                // check the action
                if ($action === self::ACTION_DELETE || $action === self::ACTION_VIEW || $action === self::ACTION_ACCEPT_APPLICATION || $action === self::ACTION_REJECT_APPLICATION || $action === self::ACTION_RESET_APPLICATION) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // check for interns actions
        else if ($model === self::MODEL_INTERNS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check if the user owns the interns
            if ($data->department->id === auth()->user()->department->id) {
                // check the action
                if ($action === self::ACTION_VIEW || $action === self::ACTION_DELETE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // if other models comes it doesn't have authorization
        else {
            return false;
        }
    }

    /**
     * check department authorizations
     *
     * @param string $model
     * @param string $action
     * @param mixed $data
     * @return bool
     */
    public function checkfacultyAuthorizations(string $model, mixed $data, string $action = null): bool
    {
        // check if the user is Admin of faculty
        if (auth()->user()->department === null) return false;

        // check for faculty actions
        if ($model === self::MODEL_INTERNSHIP) {
            // check the instance
            if (!($data instanceof Internship)) return false;


            // check if the user owns the faculty
            if ($data->department_id === auth()->user()->department->id) {
                return true;
            } else {
                return false;
            }
        }

        // check of department action
        else if ($model === self::MODEL_DEPARTMENT) {
            //check the instance 
            if (!($data instanceof FacultyDepartment)) return false;

            // check if the faculty owns the evaluation
            if ($data->faculty->id === auth()->user()->department->id) {
                return true;
            } else {
                return false;
            }
        }

        // check of evaluation action
        else if ($model === self::MODEL_EVALUATION) {
            //check the instance 
            if (!($data instanceof Evaluation)) return false;

            // check if the faculty owns the evaluation
            if ($data->department_id === auth()->user()->department->id) {
                return true;
            } else {
                return false;
            }
        }

        // check for application actions
        else if ($model === self::MODEL_APPLICATIONS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check if the user owns the application
            if ($data->internship->department->id === auth()->user()->department->id) {
                // check the action
                if ($action === self::ACTION_DELETE || $action === self::ACTION_VIEW || $action === self::ACTION_ACCEPT_APPLICATION || $action === self::ACTION_REJECT_APPLICATION || $action === self::ACTION_RESET_APPLICATION) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // check for interns actions
        else if ($model === self::MODEL_INTERNS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check if the user owns the interns
            if ($data->department->id === auth()->user()->department->id) {
                // check the action
                if ($action === self::ACTION_VIEW || $action === self::ACTION_DELETE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // check for students actions
        else if ($model === self::MODEL_STUDENTS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof User)) return false;

            // check if the user owns the interns
            if ($data->userDepartment->head_id === auth()->user()->id) {
                // check the action
                if ($action === self::ACTION_VIEW || $action === self::ACTION_DELETE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // if other models comes it doesn't have authorization
        else {
            return false;
        }
    }


    /**
     * Check company authorizations.
     *
     * @param string $model
     * @param mixed $data
     * @param string|null $action
     * @return bool
     */
    public function checkCompanyAuthorizations(string $model, mixed $data, string $action = null): bool
    {
        // Check if the user is Admin of company
        if (auth()->user()->company === null) return false;

        // Check for department actions
        if ($model === self::MODEL_DEPARTMENT) {
            // Check the instance
            if (!($data instanceof Department)) return false;

            // Check if the user owns the department
            if ($data->company_id === auth()->user()->company->id) {
                return true;
            } else {
                return false;
            }
        }
        // Check for internship actions
        else if ($model === self::MODEL_INTERNSHIP) {
            // Action is required
            if ($action === null) return false;

            // Check the instance
            if (!($data instanceof Internship)) return false;

            // Check if the user's company offers the internship
            if ($data->department->company_id === auth()->user()->company->id) {
                // Check the action
                if ($action === self::ACTION_VIEW || $action === self::ACTION_DELETE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // check for staffs actions
        else if ($model === self::MODEL_STAFF) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof User)) return false;

            // check if the user is staff
            if ($data->is_staff == '2') {
                return true;
            } else {
                return false;
            }
        }
        // Check for application actions
        else if ($model === self::MODEL_APPLICATIONS) {
            // Action is required
            if ($action === null) return false;

            // Check the instance
            if (!($data instanceof UserApplication)) return false;

            // Check if the user's company is associated with the application
            if ($data->internship->department->company_id === auth()->user()->company->id) {
                // Check the action
                if ($action === self::ACTION_DELETE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // Check for interns actions
        else if ($model === self::MODEL_INTERNS) {
            // Action is required
            if ($action === null) return false;

            // Check the instance
            if (!($data instanceof UserApplication)) return false;

            // Check if the user's company is associated with the interns
            if ($data->internship->department->company_id === auth()->user()->company->id) {
                // Check the action
                if ($action === self::ACTION_VIEW) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // If other models come it doesn't have authorization
        else {
            return false;
        }
    }

    /**
     * check user authorizations
     *
     * @param string $model
     * @param string $action
     * @param mixed $data
     * @return bool
     */
    public function checkUserAuthorizations(string $model, mixed $data, String $action = null): bool
    {
        // check if the user is not staff
        if (auth()->user()->is_staff == '1') return false;

        // check for internship actions
        if ($model === self::MODEL_INTERNSHIP) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof Internship)) return false;

            // check the action
            if ($action === self::ACTION_VIEW || $action === self::ACTION_APPLY) {
                return true;
            } else {
                return false;
            }
        }
        // check for application actions
        else if ($model === self::MODEL_APPLICATIONS) {
            // action is required
            if ($action === null) return false;

            // check the instance
            if (!($data instanceof UserApplication)) return false;

            // check if the user owns the application
            if ($data->user_id === auth()->user()->id) {
                // check the action
                if ($action === self::ACTION_DELETE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // if other models comes it doesn't have authorization
        else {
            return false;
        }
    }
}
