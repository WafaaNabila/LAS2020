<?php

namespace App\Mail;

use App\Models\LeaveApplication;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NewApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application_id;

    public function __construct($application_id)
    {
        $this->application_id = $application_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = LeaveApplication::where('id',$this->application_id)->first();
        $applicant_name = $application->user->name;
        $approver_name = $application->user->employee->approver->name;

        return $this->from('admin@igsprotech.com.my', 'Admin')
        ->subject('New Leave Application.')
        ->markdown('mails.newapplication')
        ->with([
            'url' => url('/'),
            'approver_name' => $approver_name,
            'applicant_name' => $applicant_name,
            'leave_type' => $application->refLeaveType->leave_type_name,
            'from' => $application->from,
            'to' => $application->to,
            'days_taken' => $application->days_taken,
        ]);
    }
}
