<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;

class ReminderController extends Controller
{
    // handles all the reminder features 

    public function index(){

        $appointments = Appointments::all();

        // return $appointments;
        return view('reminder')->with(['appointments' => $appointments]);
    }
}
