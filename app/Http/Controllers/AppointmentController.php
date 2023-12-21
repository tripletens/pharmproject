<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appointments;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    // fetch appointment page 

    public function index(){
        return view('appointment');
    }

    public function save_appointment(Request $request){

        // patient_name,patient_email,patient_subject, patient_appointment_time, patient_appointment_date, patient_description

        $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_email' => ['required', 'string', 'max:255'],
            'patient_appointment_time' => ['required', 'date_format:H:i'],
            'patient_appointment_date' => ['required', 'date'],
            'patient_subject' => ['required', 'string', 'max:255']
        ]);

        $prescription = Appointments::create([
            'patient_name' => $request->patient_name,
            'patient_email' => $request->patient_email,
            'patient_appointment_time' => $request->patient_appointment_time,
            'patient_appointment_date' => $request->patient_appointment_date,
            'user_id' => Auth()->user()->id,
            'code' => Str::random(8),
            'patient_subject' => $request->patient_subject,
        ]);


        if(!$prescription){
        
            toastr()->error('Appointment could not be booked, Try again later');
    
            return redirect()->back();
        }

        toastr()->success('Appointment Booked Successfully');

        return redirect()->back();
    }

}
