<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefLeaveType extends Model
{
    use HasFactory;

    public function application()
    {
        return $this->hasOne('App\Models\LeaveApplication', 'leave_type_id', 'id');
    }
}
