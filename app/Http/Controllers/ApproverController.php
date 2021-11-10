<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\ApproverMail;

use Carbon\Carbon;

use App\Models\User;
use App\Models\LeaveDetail;
use App\Models\LeaveApplication;
use App\Notifications\ApproverAlert;
use Illuminate\Support\Facades\Mail;

class ApproverController extends Controller
{

    /**
     * Display a listing of the pending applications.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function approver_list($id)
    {
        $pendings   = LeaveApplication::join('users','leave_applications.user_id','=','users.id')
                                        ->join('employee_details','users.id','=','employee_details.user_id')
                                        ->select('employee_details.*','users.*','leave_applications.*','leave_applications.id as pending_id')
                                        ->where('employee_details.approver_id', $id)
                                        ->where('application_status_id', 1)
                                        ->paginate(5, ['*'], 'pendings');
        $approved   = LeaveApplication::join('users','leave_applications.user_id','=','users.id')
                                        ->join('employee_details','users.id','=','employee_details.user_id')
                                        ->select('employee_details.*','users.*','leave_applications.*','leave_applications.id as approved_id')
                                        ->where('employee_details.approver_id', $id)
                                        ->where('application_status_id', 2)
                                        ->paginate(5, ['*'], 'approved');
        $rejected   = LeaveApplication::join('users','leave_applications.user_id','=','users.id')
                                        ->join('employee_details','users.id','=','employee_details.user_id')
                                        ->select('employee_details.*','users.*','leave_applications.*','leave_applications.id as rejected_id')
                                        ->where('employee_details.approver_id', $id)
                                        ->where('application_status_id', 3)
                                        ->paginate(5, ['*'], 'rejected');


        return view('user.approver_list', compact('pendings','approved','rejected'));
    }

    /**
     * Display a listing of the applicants list.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function applicant_list($id)
    {
        $users = User::join('employee_details','employee_details.user_id','=','users.id')
                                    ->where('approver_id' , $id )
                                    ->paginate(10);

        return view('user.applicant_list', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function approve($application)
    {
        $application->application_status_id    = 2;
        $application->approval_date            = Carbon::now();
        $application->save();

        if ($application->leave_type_id == 1 || $application->leave_type_id == 3) { //Annual & Emergency Leave
            $leave                                 = LeaveDetail::find($application->leave_id);
            $new_balance_leaves                    = ($leave->balance_leaves)-($application->days_taken);
            $leave->balance_leaves                 = $new_balance_leaves;
            $leave->taken_so_far                   += $application->days_taken;

            $leave->save();
        }

        $application_id_2 = $application->id;
        Mail::to($application->user->email)->send(new ApproverMail($application_id_2));
        $application->user->notify(new ApproverAlert($application));


        return redirect(url()->previous())->with('success', 'Application approved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function reject($application)
    {
        $application->application_status_id = 3;
        $application->approval_date         = Carbon::now();
        $application->save();

        $application_id_2 = $application->id;
        Mail::to($application->user->email)->send(new ApproverMail($application_id_2));
        $application->user->notify(new ApproverAlert($application));

        return redirect(url()->previous())->with('error', 'Application rejected.');
    }
}
