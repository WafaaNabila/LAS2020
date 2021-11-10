<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

use App\Http\Requests\ApplicationEditRequest;
use App\Http\Requests\ApplicationPostRequest;
use App\Mail\NewApplicationMail;
use App\Models\File;
use App\Models\User;
use App\Models\LeaveDetail;
use App\Models\LeaveApplication;
use App\Models\Holiday;
use App\Models\RefLeaveType;
use App\Notifications\NewApplicationAlert;

use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actives         = LeaveApplication::where('user_id', Auth::id())
                                            ->where('application_status_id','!=',3)//Approved & Pending
                                            ->where('leave_type_id','!=',2)
                                            ->where('to', '>=', Carbon::today())
                                            ->paginate(5, ['*'], 'actives');

        $pasts           = LeaveApplication::where('user_id', Auth::id())
                                            ->where('leave_type_id', '!=', 2)
                                            ->where('to', '<', Carbon::today())
                                            ->orwhere('application_status_id','=','3')
                                            ->paginate(5, ['*'], 'pasts');

        $medicals         = LeaveApplication::where('user_id', Auth::id())
                                            ->where('leave_type_id', 2)
                                            ->paginate(5, ['*'], 'medicals');



        return view('application.application_list' , compact('actives', 'pasts', 'medicals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user            = User::find(Auth::id());
        $leave           = LeaveDetail::where('user_id', $user->id)->first();
        $refLeaveTypes   = RefLeaveType::get();
        $holidays        = Holiday::pluck('holiday_date');

        JavaScriptFacade::put([
            'holidays'    => $holidays
        ]);

        return view('application.apply', compact('user','leave','refLeaveTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ApplicationPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationPostRequest $request)
    {
        $user                       = Auth::user();
        $leave                      = LeaveDetail::where('user_id', $user->id)->first();

        $from                       = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->get('from'))->format('Y-m-d'));
        $to                         = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->get('to'))->format('Y-m-d'));
        $fromDiff                   = ($from->diffInDays(Carbon::today()));
        $days_taken                 = $request->get('days_taken');
        $half_day                   = $request->get('half_day');

        if ($half_day != null) {
            $days_taken = $days_taken - (0.5);
        }

        $applications_temp          = LeaveApplication::where('user_id', $user->id)->where('application_status_id',1)->where('leave_type_id',1)->sum('days_taken');
        $applications_temp_sum      = $applications_temp + $days_taken;


            $application                = new LeaveApplication();
            $application->user_id       = $user->id;
            $application->leave_id      = $leave->id;
            $application->leave_type_id = $request->get('leave_type_id');

            //Medical & Emergency Leave & Unrecorded Leave
            if($application->leave_type_id == 2 || $application->leave_type_id == 3 || $application->leave_type_id == 4 ) //Medical or Emergency or Unrecorded
            {
                $application->from                  = $from;
                $application->to                    = $to;
                $application->days_taken            = $days_taken;
                $application->half_day              = $half_day;
                $application->reason                = $request->get('reason');


                //Medical Leave Auto-Approved
                if ($application->leave_type_id == 2)
                {
                    if($request->file('file') == null){
                        return back()->withInput()->with('error', 'Medical Leave: Please attach your MC.');
                    }
                    else {
                        $application->application_status_id = 2;
                    }
                }

                //Emergency Leave must have reason.
                if ($application->leave_type_id == 3)
                {
                    if ($request->get('reason') == null) {
                        return back()->withInput()->with('error', 'Emergency Leave: Please State Your Reason.');
                    }
                    $application->application_status_id = 1;
                }

                //Unrecorded Leave
                if ($application->leave_type_id == 4)
                {
                    $application->application_status_id = 1;
                }


                $application->save();

                //File Upload - Medical, Emergency & Unrecorded
                if($file = $request->file('file')){

                    $current_timestamp = Carbon::now()->format('Y-m-d');
                    $extension = $file->extension();
                    $filename = "($user->name)($application->id)($current_timestamp).$extension";

                    $newFile = new File();
                    $newFile->user_id        = $user->id;
                    $newFile->application_id = $application->id;
                    $newFile->filename = $filename;

                    if  ($application->leave_type_id == 2){
                        $filecategory = 'Medical_Leave_Files';
                        Storage::putFileAs($filecategory, $file, $filename);
                        $newFile->filecategory = $filecategory;
                    }
                    elseif  ($application->leave_type_id == 3){
                        $filecategory = 'Emergency_Leave_Files';
                        Storage::putFileAs($filecategory, $file, $filename);
                        $newFile->filecategory = $filecategory;
                    }
                    elseif  ($application->leave_type_id == 4){
                        $filecategory = 'Unrecorded_Leave_Files';
                        Storage::putFileAs($filecategory, $file, $filename);
                        $newFile->filecategory = $filecategory;
                    }
                    $newFile->save();
                }


                $application_id = $application->id;
                Mail::to($user->employee->approver->email)->send(new NewApplicationMail($application_id));

                $application->user->employee->approver->notify(new NewApplicationAlert($application));

                return redirect()->route('application.index')->with('success', 'Application submitted.');
            }
            else // Annual Leave
            {
                if($days_taken<= $leave->balance_leaves)
                {
                    if($applications_temp_sum <= $leave->balance_leaves) // Check Current Balance Leaves. If sufficient, proceed.
                    {

                            if($days_taken <= 2) //Annual Leave. Check days taken. If days taken <= 2 days, proceed.
                            {
                                if( $fromDiff >= 2)
                                {
                                    $application->from                  = $from;
                                    $application->to                    = $to;
                                    $application->days_taken            = $days_taken;
                                    $application->half_day              = $half_day;
                                    $application->reason                = $request->get('reason');
                                    $application->application_status_id = 1; //Pending Status

                                    $application->save();

                                    //File Upload - Annual
                                    if($file = $request->file('file')){

                                        $current_timestamp = Carbon::now()->format('Y-m-d');
                                        $extension = $file->extension();
                                        $filename = "($user->name)($application->id)($current_timestamp).$extension";

                                        $newFile = new File();
                                        $newFile->user_id        = $user->id;
                                        $newFile->application_id = $application->id;
                                        $newFile->filename = $filename;

                                        if  ($application->leave_type_id == 1){
                                            $filecategory = 'Annual_Leave_Files';
                                            Storage::putFileAs($filecategory, $file, $filename);
                                            $newFile->filecategory = $filecategory;

                                        }
                                        $newFile->save();
                                    }

                                    $application_id = $application->id;
                                    Mail::to($user->employee->approver->email)->send(new NewApplicationMail($application_id));

                                    $application->user->employee->approver->notify(new NewApplicationAlert($application));


                                    return redirect()->route('application.index')->with('success', 'Application submitted.');
                                }
                                else // Annual Leave. Days taken <= 2 days, but 1 day before. Error. Must apply 2 days before.
                                {
                                    return back()->withInput()->with('error', 'Cannot Apply: Application Must Be Applied 2 Days Before!');

                                }

                            }
                            else //Annual Leave. More than 2 days, error. Must apply 7 days prior.
                            {
                                if($fromDiff >= 7)
                                {
                                    $application->from                  = $from;
                                    $application->to                    = $to;
                                    $application->days_taken            = $days_taken;
                                    $application->half_day              = $half_day;
                                    $application->reason                = $request->get('reason');
                                    $application->application_status_id = 1; // Pending Status

                                    $application->save();

                                    //File Upload - Annual
                                    if($file = $request->file('file')){

                                        $extension = $file->extension();
                                        $filename = "$application->id.$extension";

                                        $newFile = new File();
                                        $newFile->user_id        = $user->id;
                                        $newFile->application_id = $application->id;
                                        $newFile->filename = $filename;

                                        if  ($application->leave_type_id == 1){
                                            $filecategory = 'Annual_Leave_Files';
                                            Storage::putFileAs($filecategory, $file, $filename);
                                            $newFile->filecategory = $filecategory;

                                        }
                                        $newFile->save();
                                    }

                                    $application_id = $application->id;
                                    Mail::to($user->employee->approver->email)->send(new NewApplicationMail($application_id));

                                    $application->user->employee->approver->notify(new NewApplicationAlert($application));



                                    return redirect()->route('application.index')->with('success', 'Application submitted.');
                                }
                                else
                                {
                                    return back()->withInput()->with('error', 'Cannot Apply: Application More Than 2 Days Must Be Applied 7 Days Before!');
                                }
                            }


                    }
                    else// If Pending Applications' Days Taken Exceeds Leave Balance, Error.
                    {
                        return back()->withInput()->with('error', 'Cannot Apply: Pending Applications Exceeds Leave Balance!');

                    }
                }
                else // If Current Balance Leaves not sufficient, error.
                {
                        return back()->withInput()->with('error', 'Cannot Apply: Insufficient Leave Balance!');
                }
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function show($application)
    {
        $created_at     = date('d/m/Y (H:i:s)', strtotime($application->created_at));

        if($application->half_day == 1){
            $half_day = 'Morning';
        }
        else if ($application->half_day == 2){
            $half_day = 'Evening';
        }
        else {
            $half_day = null;
        }

        $file = File::where('filename', $application->id)->first();

        return view('application.application_show', compact('application','created_at','half_day','file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function edit($application)
    {
        $from        = Carbon::parse($application->from)->format('d/m/Y');
        $to          = Carbon::parse($application->to)->format('d/m/Y');
        $holidays    = Holiday::pluck('holiday_date');

        JavaScriptFacade::put([
            'holidays'    => $holidays
        ]);


        return view('application.application_edit', compact('application','from','to'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ApplicationEditRequest  $request
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationEditRequest $request, $application)
    {
        $application->from          = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->get('from'))->format('Y-m-d'));
        $application->to            = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->get('to'))->format('Y-m-d'));
        $days_taken                 = $request->get('days_taken');
        $half_day                   = $request->get('half_day');

        if ($half_day != null) {
            $days_taken = $days_taken - (0.5);
        }

        $application->half_day      = $half_day;
        $application->days_taken    = $days_taken;
        $application->reason        =  $request->get('reason');
        $application->save();

        return redirect()->route('application.index')->with('success', 'Application updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\LeaveApplication $application
     * @return \Illuminate\Http\Response
     */
    public function destroy($application)
    {
        if(File::where('application_id', $application->id)->exists()){
            $file        = File::where('application_id', $application->id)->first();
            Storage::delete("$file->filecategory/$file->filename");
            $file->delete();
        }

        $application->delete();

        return back()->withInput()->with('error', 'Application removed.');
    }

}
