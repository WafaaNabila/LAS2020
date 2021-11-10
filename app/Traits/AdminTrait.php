<?php

namespace App\Traits;

use App\Models\EmployeeDetail;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\LeaveDetail;
use App\Models\User;
use Carbon\Carbon;

trait AdminTrait
{
    public function dashboardAdmins()
    {
        //Employees
        $employees                      = User::where('id','!=', 1)->get();
        $resigned                       = User::where('id','!=', 1)
                                            ->where('emp_status_id', 2)
                                            ->get();


        $employees_count                = $employees->count();
        $male_count                     = EmployeeDetail::where('gender_id',1)->count();
        $female_count                   = EmployeeDetail::where('gender_id',2)->count();
        $admin_count                    = User::where('role_id',1)->count();
        $employee_count                 = User::where('role_id',2)->count();
        $approver_count                 = User::where('role_id',3)->count();

        $working_count                  = User::where('id','!=', 1)->where('emp_status_id',1)->count();
        $resigned_count                 = $resigned->count();


        //Leave
        $taken_so_far_sum                   = LeaveDetail::sum('taken_so_far');
        $carry_over_sum                     = LeaveDetail::sum('carry_over');
        $balance_leaves_sum                 = LeaveDetail::sum('carry_over');

        $taken_so_far_sum_average           = LeaveDetail::avg('taken_so_far');
        $annual_e_average                   = LeaveDetail::avg('annual_e');

        //Applications
        $applications                   = LeaveApplication::all();
        $applications_count             = $applications->count();
        $applications_this_year         = LeaveApplication::whereYear('created_at', date('Y'))->get();
        $applications_this_year_count   = $applications_this_year->count();

        $pending_count                  = LeaveApplication::where('application_status_id',1)->count();
        $approve_count                  = LeaveApplication::where('application_status_id',2)->count();
        $reject_count                   = LeaveApplication::where('application_status_id',3)->count();

        $pending_this_year_count        = LeaveApplication::whereYear('created_at', date('Y'))->where('application_status_id',1)->count();
        $approve_this_year_count        = LeaveApplication::whereYear('created_at', date('Y'))->where('application_status_id',2)->count();
        $reject_this_year_count         = LeaveApplication::whereYear('created_at', date('Y'))->where('application_status_id',3)->count();

        //Holidays
        $holidays                       = Holiday::all();

        $monday_count = $tuesday_count = $wednesday_count =
        $thursday_count = $friday_count = $saturday_count = $sunday_count =  0 ;

        $january_count = $february_count = $march_count = $april_count=
        $may_count = $june_count = $july_count = $august_count = $september_count =
        $october_count = $november_count = $december_count = 0;


        foreach($holidays as $holiday){
           $day = Carbon::parse($holiday->holiday_date)->englishDayOfWeek;
           $month = Carbon::parse($holiday->holiday_date)->englishMonth;

           switch ($day) {
               case 'Monday':
                   $monday_count++;
                   break;
               case 'Tuesday':
                   $tuesday_count++;
                   break;
               case 'Wednesday':
                   $wednesday_count++;
                   break;
               case 'Thursday':
                   $thursday_count++;
                   break;
               case 'Friday':
                   $friday_count++;
                   break;
               case 'Saturday':
                   $saturday_count++;
                   break;
               case 'Sunday':
                   $sunday_count++;
                   break;
               default:
                   break;
           }

           switch ($month) {
               case 'January':
                   $january_count++;
                   break;
               case 'February':
                   $february_count++;
                   break;
               case 'March':
                   $march_count++;
                   break;
               case 'April':
                   $april_count++;
                   break;
               case 'May':
                   $may_count++;
                   break;
               case 'June':
                   $june_count++;
                   break;
               case 'July':
                   $july_count++;
                   break;
               case 'August':
                   $august_count++;
                   break;
               case 'September':
                   $september_count++;
                   break;
               case 'October':
                   $october_count++;
                   break;
               case 'November':
                   $november_count++;
                   break;
               case 'December':
                   $december_count++;
                   break;
               default:
                   break;
           }
        }

        $dayarray = array
                (
            'monday_count' => $monday_count,
            'tuesday_count' => $tuesday_count,
            'wednesday_count' => $wednesday_count,
            'thursday_count' => $thursday_count,
            'friday_count' => $friday_count,
            'saturday_count' => $saturday_count,
            'sunday_count' => $sunday_count,
            );


        $montharray = array
                (
            'january_count' => $january_count,
            'february_count' => $february_count,
            'march_count' => $march_count,
            'april_count' => $april_count,
            'may_count' => $may_count,
            'june_count' => $june_count,
            'july_count' => $july_count,
            'august_count' => $august_count,
            'september_count' => $september_count,
            'october_count' => $october_count,
            'november_count' => $november_count,
            'december_count' => $december_count,
            );

        $highest_day_value = max($dayarray);
        $highest_month_value = max($montharray);

        $holidays_count                 = $holidays->count();


        return compact(
            'employees',
            'employees_count',
            'male_count',
            'female_count',
            'admin_count',
            'employee_count',
            'approver_count',
            'working_count',
            'resigned_count',
            'taken_so_far_sum',
            'carry_over_sum',
            'balance_leaves_sum',
            'taken_so_far_sum_average',
            'annual_e_average',
            'applications_count',
            'applications_this_year_count',
            'pending_count',
            'approve_count',
            'reject_count',
            'pending_this_year_count',
            'approve_this_year_count',
            'reject_this_year_count',
            'holidays_count',
            'monday_count',
            'tuesday_count',
            'wednesday_count',
            'thursday_count',
            'friday_count',
            'saturday_count',
            'sunday_count',
            'january_count',
            'february_count',
            'march_count',
            'april_count',
            'may_count',
            'june_count',
            'july_count',
            'august_count',
            'september_count',
            'october_count',
            'november_count',
            'december_count',
            'highest_day_value',
            'highest_month_value',
        );
    }

    public function resignApprover($id)
    {
        $employees   = EmployeeDetail::where('approver_id' , $id)->get();
        foreach ($employees as $employee)
        {
            $employee->approver_id = null;
            $employee->save();
        }
    }

    public function employeeReport($id)
    {
        $applications       = LeaveApplication::where('user_id', $id)->get();
        $applications_this_year = LeaveApplication::whereYear('created_at', date('Y'))->where('user_id', $id)->get();
        $applications_count = $applications->count();
        $applications_this_year_count = $applications_this_year->count();

        $pending_count      = $applications->where('application_status_id',1)->count();
        $approved_count     = $applications->where('application_status_id',2)->count();
        $rejected_count     = $applications->where('application_status_id',3)->count();

        $applications_days_taken_sum = $applications->where('application_status_id',2)->sum('days_taken');
        $applications_days_taken_avg = $applications->where('application_status_id',2)->avg('days_taken');

        return compact(
            'applications_count',
            'applications_this_year_count',
            'pending_count',
            'approved_count',
            'rejected_count',
            'applications_days_taken_sum',
            'applications_days_taken_avg',
        );
    }

}
