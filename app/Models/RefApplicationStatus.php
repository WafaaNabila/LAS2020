<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefApplicationStatus extends Model
{
    use HasFactory;

    public function application()
    {
        return $this->hasOne('App\Models\LeaveApplication', 'application_status_id', 'id');
    }

}
