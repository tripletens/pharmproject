<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DrugInteractionController extends Controller
{
    // Handles all the drug interaction 

    public function index(){
        return view('druginteraction');
    }
}
