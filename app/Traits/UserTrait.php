<?php

namespace App\Traits;

use App\Models\LeaveApplication;
use App\Models\LeaveDetail;
use App\Models\User;

trait UserTrait
{
    public function employeeShow($id)
    {
        //Validation For Approver's Name
        $user       = User::find($id);
        $leave      = LeaveDetail::where('user_id', $id)->first();



            if($user->employee->approver_id == null)
            {
                $current_approver_name = "None";
            }
            else
            {
                if(User::where('id', $user->employee->approver_id)->exists())
                {
                    $current_approver_name = $user->employee->approver->name;
                }
                else
                {
                    $user->employee->approver_id = null;
                    $user->save();
                    $current_approver_name = "None";
                }
            }




        $current_approver_id = $user->employee->approver_id;

        return compact('user', 'leave', 'current_approver_name', 'current_approver_id');
    }

    public function dashboardEmployees($id)
    {
        $user = User::find($id);
        $applications_count =  LeaveApplication::where('user_id', $id)->count();
        $applications_count_this_year =  LeaveApplication::whereYear('created_at', date('Y'))->where('user_id', $id)->count();

        $approvers_pending_count = LeaveApplication::join('employee_details','leave_applications.user_id','=','employee_details.user_id')
                                                    ->select('employee_details.approver_id','leave_applications.*', 'leave_applications.id as applicationID')
                                                    ->where('application_status_id', 1)
                                                    ->where('employee_details.approver_id', $id)
                                                    ->count();

        return compact('user', 'applications_count', 'applications_count_this_year','approvers_pending_count');
    }
}
