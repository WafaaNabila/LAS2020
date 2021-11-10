<?php

namespace App\Traits;
use Carbon\Carbon;

use App\Models\EmployeeDetail;
use App\Models\LeaveDetail;

trait LeaveTrait
{
    public function createLeave($id)
    {
        $employee               = EmployeeDetail::find($id);
        //Calculate Annual Entitlement for New Employees
        $DaysperAnnualLeave     = 365/14;
        $date_joined            = Carbon::parse($employee->date_joined);
        $year_end               = Carbon::parse(Carbon::now()->endOfYear());
        $servicedays            = ($year_end->diffInDays($date_joined))+1;
        $annual_e               = $servicedays/$DaysperAnnualLeave;

        $rounded                = round($annual_e, 1);	//Round off to nearest 0.0
        $entitlement            = round($rounded); //Round off to whole number

        // //For Pushing Input Into DB (Leaves Table)
        $leave                  = new LeaveDetail();
        $leave->user_id         = $employee->user_id;
        $leave->annual_e        = $entitlement;
        $leave->carry_over      = 0;
        $leave->taken_so_far    = 0;
        //Calculate Total and Balance Leaves
        $leave->total_leaves    = ($leave->annual_e     + $leave->carry_over);
        $leave->balance_leaves  = ($leave->total_leaves - $leave->taken_so_far);
        //For Pushing Input(Leaves Table)
        $leave->save();
    }
}
