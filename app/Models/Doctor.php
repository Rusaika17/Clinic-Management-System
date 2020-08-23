<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
	protected $fillable = 
    [
        'first_name', 'middle_name', 'last_name','email', 'nic', 'phone', 'description', 'education', 'speciality', 'address', 'working_day' , 'in_time' , 'out_time' ,
        'type' , 'department_id'
    ];

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment');
    }
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
    public function opd_sales()
    {
        return $this->hasMany('App\Models\OpdSales');
    }
     public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }

    public function doctor_referred()
    {
         return $this->hasMany('App\Models\DoctorReferred');
    }
    //
}
