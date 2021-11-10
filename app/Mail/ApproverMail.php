<?php

namespace App\Mail;

use App\Models\LeaveApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproverMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application_id_2;

    public function __construct($application_id_2)
    {
        $this->application_id_2 = $application_id_2;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $application = LeaveApplication::where('id',$this->application_id_2)->first();
        $applicant_name = $application->user->name;

        return $this->from('admin@igsprotech.com.my', 'Admin')
        ->subject('Leave Application Status.')
        ->markdown('mails.applicationapproval')
        ->with([
            'applicant_name' => $applicant_name,
            'status' => $application->refAppStatus->application_status_name,
            'approval_date' => $application->approval_date,
            'leave_type' => $application->refLeaveType->leave_type_name,
            'from' => $application->from,
            'to' => $application->to,
            'days_taken' => $application->days_taken,
        ]);
    }
}
