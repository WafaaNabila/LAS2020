<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminEditRequest;
use App\Http\Requests\AdminPostRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Models\User;
use App\Models\EmployeeDetail;
use App\Models\LeaveApplication;
use App\Models\RefRole;
use App\Models\RefEmpStatus;
use App\Models\RefGender;
use App\Traits\AdminTrait;
use App\Traits\IndexTrait;
use App\Traits\LeaveTrait;
use App\Traits\UserTrait;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    use LeaveTrait;
    use UserTrait;
    use AdminTrait;
    use IndexTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkPendingApplication();
        $array  = $this->dashboardAdmins();
        $array2 = $this->off_duty();

        $employees_count                = $array['employees_count'];
        $applications_count             = $array['applications_count'];
        $applications_this_year_count   = $array['applications_this_year_count'];
        $holidays_count                 = $array['holidays_count'];
        $resigned_count                 = $array['resigned_count'];
        $taken_so_far_sum               = $array['taken_so_far_sum'];
        $offduty                        = $array2['offduty'];
        $offduty_count                  = $array2['offduty_count'];

        return view(
            'admin.dashboard',
            compact(
                'offduty',
                'offduty_count',
                'employees_count',
                'applications_count',
                'applications_this_year_count',
                'taken_so_far_sum',
                'holidays_count',
                'resigned_count'
            )
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $approvers  = User::where('role_id', 3)->where('emp_status_id', 1)->get();
        $roles      = RefRole::where('id', '!=', 1)->get();
        $genders    = RefGender::all();

        return view('admin.employee_add', compact('approvers', 'roles', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\AdminPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPostRequest $request)
    {

        $user                    = new User();
        $user->name              = $request->get('name');
        $user->email             = $request->get('email');
        $user->role_id           = $request->get('role_id');
        $user->password          = Hash::make("igsprotech2020");
        $user->emp_status_id     = 1;
        $user->save();

        $employee                = new EmployeeDetail();
        $employee->user_id       = $user->id;
        $employee->phoneNum      = $request->get('phoneNum');
        $employee->ic            = $request->get('ic');
        $employee->gender_id     = $request->get('gender_id');
        $employee->date_joined   = Carbon::createFromFormat('d/m/Y', $request->get('date_joined'))->format('Y-m-d');
        $employee->approver_id   = $request->get('approver_id');
        $employee->last_carry_over = Carbon::now()->year;
        $employee->save();

        $this->createLeave($employee->id);

        return redirect()->route('admin.create')->with('success', 'Employee added.');
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

        return view('admin.employee_show', compact('user', 'leave', 'current_approver_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user                   = User::find($id);
        $approvers              = User::where('role_id', 3)
                                        ->where('emp_status_id', 1)
                                        ->get();
        $refEmpStatus           = RefEmpStatus::get();

        $array                  = $this->employeeShow($id);
        $current_approver_id    = $array['current_approver_id'];
        $current_approver_name  = $array['current_approver_name'];

        return view('admin.employee_edit', compact('user', 'approvers', 'refEmpStatus', 'current_approver_id', 'current_approver_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\AdminEditRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminEditRequest $request, $id)
    {
        $user                           = User::find($id);
        $employee                       = EmployeeDetail::where('user_id', $id)->first();

        if((User::where('email', $request->get('email'))->exists()) && ($user->email != $request->get('email')) )
        {
            return back()->withInput()->with('error', 'Email exists! Please enter another email address!');
        }

        $user->name                     = $request->get('name');
        $user->email                    = $request->get('email');
        $user->emp_status_id            = $request->get('emp_status_id');
        $user->save();

        $employee->phoneNum             = $request->get('phoneNum');
        $employee->approver_id          = $request->get('approver_id');
        $employee->save();

        return redirect()->route('admin.employee_list')->with('success', 'Employee Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user                   = User::find($id);
        $user->emp_status_id    = 2;
        $user->save();

        if($user->position_id == 3)
        {
            $this->resignApprover($id);
        }

        return redirect()->route('admin.employee_list')->with('error', 'Employee Resigned.');
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function employee_list()
    {
        $users = User::join('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->select('users.*', DB::raw('DATE_FORMAT(employee_details.date_joined, "%d %M, %Y") as date_joined'))
            ->where('users.id', '!=', 1)
            ->paginate(10);

        return view('admin.employee_list', compact('users'));
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->search;

        $users = User::where('id', '!=', 1)->where('name', 'like', "%{$query}%")->paginate(10);

        // dd($users);
        return view('admin.employee_list', compact('users', 'query'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function application_list()
    {
        $applications = LeaveApplication::join('users', 'leave_applications.user_id', '=', 'users.id')
            ->select('leave_applications.*', 'users.name', 'leave_applications.id as leave_applications_id')
            ->where('users.id', '!=', 1)
            ->paginate(10);

        return view('admin.application_list', compact('applications'));
    }

}
