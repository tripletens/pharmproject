<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DrugInteraction;

class DrugInteractionController extends Controller
{
    // Handles all the drug interaction 

    public function index(){ 

        $user_id = Auth()->user()->id; 

        $drugInteraction = DrugInteraction::where('user_id', $user_id)->get();

        return view('druginteraction')->with(['drugInteraction' => $drugInteraction]);
    }


    public function saveDrug(Request $request){
        // 
        // $this->vale
    }


}
