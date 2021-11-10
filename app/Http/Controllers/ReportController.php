<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use App\Models\User;
use App\Traits\AdminTrait;
use App\Traits\UserTrait;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use UserTrait;
    use AdminTrait;


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        $array = $this->dashboardAdmins();

        //Employee
        $employees_count                = $array['employees_count'];
        $male_count                     = $array['male_count'];
        $female_count                   = $array['female_count'];
        $admin_count                    = $array['admin_count'];
        $employee_count                 = $array['employee_count'];
        $approver_count                 = $array['approver_count'];
        $working_count                  = $array['working_count'];
        $resigned_count                 = $array['resigned_count'];

        //Leave
        $taken_so_far_sum               = $array['taken_so_far_sum'];
        $carry_over_sum                 = $array['carry_over_sum'];
        $balance_leaves_sum             = $array['balance_leaves_sum'];

        $taken_so_far_sum_average       = $array['taken_so_far_sum_average'];
        $annual_e_average               = $array['annual_e_average'];

        //Application
        $applications_count             = $array['applications_count'];
        $applications_this_year_count   = $array['applications_this_year_count'];
        $applications_other_year_count  = $applications_count - $applications_this_year_count;

        $pending_count                  = $array['pending_count'];
        $approve_count                  = $array['approve_count'];
        $reject_count                   = $array['reject_count'];
        $pending_this_year_count        = $array['pending_this_year_count'];
        $approve_this_year_count        = $array['approve_this_year_count'];
        $reject_this_year_count         = $array['reject_this_year_count'];


        //Holiday
        $holidays_count                 = $array['holidays_count'];
        $monday_count                   = $array['monday_count'];
        $tuesday_count                  = $array['tuesday_count'];
        $wednesday_count                = $array['wednesday_count'];
        $thursday_count                 = $array['thursday_count'];
        $friday_count                   = $array['friday_count'];
        $saturday_count                 = $array['saturday_count'];
        $sunday_count                   = $array['sunday_count'];

        $january_count                  = $array['january_count'];
        $february_count                 = $array['february_count'];
        $march_count                    = $array['march_count'];
        $april_count                    = $array['april_count'];
        $may_count                      = $array['may_count'];
        $june_count                     = $array['june_count'];
        $july_count                     = $array['july_count'];
        $august_count                   = $array['august_count'];
        $september_count                = $array['september_count'];
        $october_count                  = $array['october_count'];
        $november_count                 = $array['november_count'];
        $december_count                 = $array['december_count'];

        $highest_day_value              = $array['highest_day_value'];
        $highest_month_value            = $array['highest_month_value'];

        JavaScriptFacade::put([
            'male_count'    => $male_count,
            'female_count'  => $female_count,
            'pending_count' =>  $pending_count,
            'approve_count' => $approve_count,
            'reject_count'  => $reject_count,
            'admin_count'   => $admin_count,
            'employee_count'=> $employee_count,
            'approver_count'=> $approver_count,
            'working_count' => $working_count,
            'resigned_count'  => $resigned_count,
            'applications_count' => $applications_count,
            'applications_this_year_count' => $applications_this_year_count,
            'applications_other_year_count' => $applications_other_year_count,
            'monday_count'=> $monday_count,
            'tuesday_count'=> $tuesday_count,
            'wednesday_count'=> $wednesday_count,
            'thursday_count'=> $thursday_count,
            'friday_count' => $friday_count,
            'saturday_count'=> $saturday_count,
            'sunday_count'=> $sunday_count,
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
            'highest_day_value' => $highest_day_value,
            'highest_month_value' => $highest_month_value,
        ]);

        return view('report.overview_report', compact(
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
            'applications_other_year_count',
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
        ));
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function individual()
    {
        $users = User::join('employee_details','employee_details.user_id','=','users.id')
                    ->select('users.*', DB::raw('DATE_FORMAT(employee_details.date_joined, "%d %M, %Y") as date_joined','users.id as userID'))
                    ->where('users.id', '!=' , 1)
                    ->paginate(10);

        return view('report.individual_list', compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->search;

        $users = User::where('id', '!=', 1)->where('name', 'like', "%{$query}%")->paginate(10);


        return view('report.individual_list', compact('users','query'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view_individual($id)
    {
        $array                 = $this->employeeShow($id);
        $array2                = $this->employeeReport($id);

        $user                  = $array['user'];
        $leave                 = $array['leave'];
        $current_approver_name = $array['current_approver_name'];

        $applications_count    = $array2['applications_count'];
        $applications_this_year_count    = $array2['applications_this_year_count'];
        $pending_count         = $array2['pending_count'];
        $approved_count        = $array2['approved_count'];
        $rejected_count        = $array2['rejected_count'];

        $applications_days_taken_sum        = $array2['applications_days_taken_sum'];
        $applications_days_taken_avg        = $array2['applications_days_taken_avg'];

        JavaScriptFacade::put([
            'individual_pending_count' =>  $pending_count,
            'individual_approve_count' => $approved_count,
            'individual_reject_count'  => $rejected_count,
        ]);

        return view('report.individual_report' , compact(
            'user',
            'leave',
            'current_approver_name',
            'applications_count',
            'applications_this_year_count',
            'pending_count',
            'approved_count',
            'rejected_count',
            'applications_days_taken_sum',
            'applications_days_taken_avg',
        ));
    }


}



