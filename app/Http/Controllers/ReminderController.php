<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReminderController extends Controller
{
    // handles all the reminder features 

    public function index(){
        return view('reminder');
    }
}
