<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefGender extends Model
{
    use HasFactory;
    
    public function employee()
    {
        return $this->hasOne('App\Models\EmployeeDetail', 'gender_id', 'id');
    } 
}
