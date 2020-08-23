<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Employee;
use App\Models\OpdSales;
use App\Models\Hospital;

class doctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::all();
        $departments = Department::select('id','name')->get();
//        $employees = Employee::where('type', 'Doctor')->get();
        //$days = explode(',',$doctors->working_day);
        return view('doctors.index' , compact('doctors', 'departments'));

        //
    }


    public function create()
    {
        $departments = Department::select('id','name')->get();
        return view('doctors.create', compact('departments'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();

        $this->validate($request, ['first_name'=>'required',
            'last_name'=> 'required',
            'email'=>'required|email|unique:employees',
            'phone'=>'required|regex:/(0)[0-9]{9}/',
            'working_day'=>'required',
            'nic'=>'required',]);

        if (count($request->working_day)) {
            $request['working_day'] = implode(',',$request->working_day);
        }
        $data = $request->all();
        $data['first_name'] = 'DR.'.$request->first_name;

//        return $data;
        Doctor::create($data);
//        return back()->with('success', 'Doctor saved Successfully.');
        return redirect()->route('doctor.index')->with('success', 'Doctor saved Successfully.');
    }
    public function edit($id)
    {
        //return $id;
        $opd = Doctor::find($id);
        //return $opd;

        if($opd->employee->status == 0)
        {
            $status['status'] = 1;
        }else
        {
            $status['status'] = 0;
        }

        $opd->update($status);

        return back()->with('success', 'Doctor active Successfully');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $s = date('D, d M Y');
        $doctor = Doctor::find($id);
//        return $doctor;
        $departments = Department::select('id','name')->get();
//        $employees = Employee::get();
        $appointments = Appointment::where('doctor_id', $id)->get();
//        return $appointments;
        return view('doctors.profile', compact('doctor','departments','appointments', 's'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $doctor = Doctor::find ( $id );

        if($request->with_tax) {

            $tax_cal = 100 + $tax;
            $request['fee'] = $request->fee*100/$tax_cal;
            $request['opd_charge'] = $request->opd_charge*100/$tax_cal;
        }
        
        $doctor->update($request->all());
        $departments = Department::get();
         return back()->with('success', 'Doctor Updated Successfully');
        //
    }

     
    public function destroy($id)
    {
        $doctor = Doctor::find($id);

        if (count($doctor->opd_sales) || count($doctor->reports) || count($doctor->doctor_referred) || count($doctor->appointments) ){
            return back()->with('error', 'Doctor cannot delted..');
        }
        $doctor->delete();
        return redirect()->route('doctor.index')->with('success', 'Doctor Deletetd Successfully');  
     
    } 

}
