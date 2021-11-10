<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLog;
use App\Traits\IndexTrait;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use UserTrait;
    use IndexTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->yearlyCarryOver();
        $this->checkPendingApplication();
        $this->yearlyCarryOver(Auth::id());
        $this->off_duty();

        $array              = $this->dashboardEmployees(Auth::id());
        $user               = $array['user'];
        $applications_count = $array['applications_count'];
        $applications_count_this_year = $array['applications_count_this_year'];
        $approvers_pending_count = $array['approvers_pending_count'];

        return view('user.dashboard', compact('user' , 'applications_count','applications_count_this_year','approvers_pending_count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $array                 = $this->employeeShow($id);
        $user                  = $array['user'];
        $leave                 = $array['leave'];
        $current_approver_name = $array['current_approver_name'];

        return view('user.employee_detail' , compact('user','leave','current_approver_name'));
    }

    /**
     * Marks notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function read_notifications()
    {
        //Must access User model to use Notifiable trait.
        $user = User::find(Auth::id());
        $user->unreadNotifications->markAsRead();

        return redirect()->route('user.view_notifications');
    }

    /**
     * Show the notifications page.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_notifications()
    {
        //Workaround to notifications() 1013 error.
        //Must access User model to use Notifiable trait.
        $user = User::find(Auth::id());
        $notifications = $user->notifications()->paginate(5);

       return view('user.notifications', compact('notifications'));
    }

    /**
     * Clears the notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function clear_notifications()
    {
        //Must access User model to use Notifiable trait.
        $user = User::find(Auth::id());
        $user->notifications()->delete();

        return redirect()->route('user.view_notifications')->withInput()->with('success', 'Notifications cleared.');
    }

    /**
     * Show the attendance page.
     *
     * @return \Illuminate\Http\Response
     */
    public function attendance_view()
    {
        $today      = UserLog::where('user_id', Auth::id())
                    ->whereDate('created_at', Carbon::today()
                    ->toDateString())
                    ->first();

        $all_logs  = UserLog::where('user_id', Auth::id())
                    ->orderBy('date','DESC')
                    ->paginate(5);

        return view('user.user_log', compact('today','all_logs'));
    }

    /**
     * Clock In.
     *
     * @return \Illuminate\Http\Response
     */
    public function clock_in()
    {
        if(UserLog::where('user_id', Auth::id())->whereDate('created_at', Carbon::today()->toDateString())->doesntExist()){
            $new_log = new UserLog();
            $new_log->user_id   = Auth::id();
            $new_log->date      = Carbon::now()->toDateString();
            $new_log->clock_in  = Carbon::now()->format('h:i:s');
            $new_log->save();

            return redirect()->route('attendance.view')->with('success', 'You have clocked in.');
        }
        else {
            return redirect()->route('attendance.view')->with('error', 'You have already clocked in!');
        }
    }

    /**
     * Clock Out.
     *
     * @return \Illuminate\Http\Response
     */
    public function clock_out()
    {
        if ($today = UserLog::where('user_id', Auth::id())->whereDate('created_at', Carbon::today()->toDateString())->first()) {

            $today->clock_out = Carbon::now()->format('h:i:s');
            $seconds = Carbon::parse($today->clock_in)->diffInSeconds(Carbon::parse($today->clock_out));

            if($seconds < 60){
                    $today->period = $seconds.'s';
            }
            else {
                $minutes = floor(($seconds / 60) % 60);

                if($minutes < 60){
                    $today->period = $minutes.'m';
                }
                else{
                    $hours = floor(($seconds / 3600)-1);
                    $today->period = $hours.'h '.$minutes.'m';
                }
            }
            $today->save();

            return redirect()->route('attendance.view')->with('success', 'You have clocked out!');
        }
        else {
            return redirect()->route('attendance.view')->with('error', 'You have not clocked in today.');
        }
    }
}
