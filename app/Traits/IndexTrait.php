<?php

namespace App\Traits;

use App\Models\LeaveApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait IndexTrait
{
    public function checkPendingApplication()
    {
        if (LeaveApplication::where('to', '<=', Carbon::today())->exists()  ) {
            $applications = LeaveApplication::where('to', '<', Carbon::today())->get();

            foreach($applications as $application){
                if($application->application_status_id == 1)
                {
                    if ($application->leave_type_id == 1) {
                        $application->application_status_id = 3;
                        $application->approval_date         = Carbon::now();
                        $application->save();
                    }
                }
            }
        }
    }

    public function yearlyCarryOver()
    {
        $user = Auth::user();
        $current_year   = Carbon::now()->year;

            if($current_year > $user->employee->last_carry_over)
            {
                    $user->leave->annual_e         = 14;
                    $user->leave->taken_so_far     = 0;
                    $user->leave->carry_over       =  $user->leave->balance_leaves;
                    $user->leave->total_leaves     = ($user->leave->annual_e)+($user->leave->carry_over);
                    $user->leave->balance_leaves   = ($user->leave->total_leaves)-($user->leave->taken_so_far);
                    $user->leave->save();

                    $user->employee->last_carry_over = $current_year;
                    $user->employee->save();
            }

    }

    public function off_duty()
    {
        $today  = Carbon::today()->locale('en_MY');
        $start  = $today->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        $end    = $today->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');

        $offduty     = LeaveApplication::join('users','leave_applications.user_id','=','users.id')
                                        ->select('leave_applications.*','users.*','users.id as userID')
                                        ->where(function ($query) use ($start, $end)
                                        {
                                            $query->where('leave_applications.application_status_id', 2)
                                                    ->where('leave_applications.from','>=', $start)
                                                    ->where('leave_applications.from','<=', $end);
                                        })
                                        ->orWhere(function($query) use ($start, $end)
                                        {
                                            $query->where('leave_applications.application_status_id', 2)
                                                    ->where('leave_applications.from','<', $start)
                                                    ->where('leave_applications.to','>', $end);
                                        })
                                        ->orWhere(function($query) use ($start, $today)
                                        {
                                            $query->where('leave_applications.application_status_id', 2)
                                                    ->where('leave_applications.to','>=', $start)
                                                    ->where('leave_applications.to','<', $today);
                                        })
                                        ->paginate(5);


        if (isset($offduty))
        {
            foreach ($offduty as $ofd)
            {   $user = User::find($ofd->userID);

                if($ofd->days_taken < 3)
                {
                    $ofd->user->emp_status_id = 3; //Leave
                }
                else
                {
                    $ofd->user->emp_status_id = 4; //Long Leave
                }
                    $ofd->user->save();
            }
        }

        $ofd_id = $offduty->pluck('userID');
        $users  = User::pluck('id');
        $ond_id = $users->diff($ofd_id);

        if (isset($ond_id))
        {
            foreach ($ond_id as $id) {
                $check = User::find($id);
                if($check->emp_status_id == 3 || $check->emp_status_id == 4)
                {
                    $check->emp_status_id = 1;
                    $check->save();
                }
            }
        }

        $offduty_count      = LeaveApplication::where(function ($query) use ($start, $end)
                                            {
                                                $query->where('application_status_id', 2)
                                                        ->where('from','>=', $start)
                                                        ->where('from','<=', $end);
                                            })
                                            ->orWhere(function($query) use ($start, $end)
                                            {
                                                $query->where('application_status_id', 2)
                                                        ->where('from','<', $start)
                                                        ->where('to','>', $end);
                                            })
                                            ->orWhere(function($query) use ($start, $today)
                                            {
                                                $query->where('application_status_id', 2)
                                                        ->where('to','>=', $start)
                                                        ->where('to','<', $today);
                                            })
                                            ->distinct('user_id')
                                            ->count();

        return compact('offduty','offduty_count');
    }
}
