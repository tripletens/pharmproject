<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescriptions;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HealthInfoController extends Controller
{
    // handles all the health info functions 

    public function __construct(){
       
    }

    public function index(){

        // get all the prescriptions for the user 
        $user_id = Auth()->user()->id;
        $get_user_prescriptions = Prescriptions::where('user_id', $user_id)->simplePaginate(4);
       
        $format_dates = $get_user_prescriptions->map(function ($item) {
            // Assuming $item->start_date and $item->end_date are in Y-m-d format (e.g., "2023-08-02")
            $start_date = Carbon::parse($item->start_date);
            $end_date = Carbon::parse($item->end_date);

            // Format the start date as "2nd August 2023"
            $formatted_start_date = $start_date->format('jS F Y');

            // Format the end date as "2nd August 2023"
            $formatted_end_date = $end_date->format('jS F Y');

            // Add the formatted dates to the item as new attributes
            $item->formatted_start_date = $formatted_start_date;
            $item->formatted_end_date = $formatted_end_date;

            return $item;
        })->toArray();

        if(!$get_user_prescriptions){
            toastr()->error('Prescription could not be fetched, Try again later');
        }
        
        // toastr()->success('Prescript÷ions fetched successfully');

        return view('healthinfo')->with(['prescriptions' => $get_user_prescriptions]);
    }

    public function save_medication(Request $request){

        // medication_name, medication_mode, start_date, end_date, medication_frequency

        $request->validate([
            'medication_name' => ['required', 'string', 'max:255'],
            'medication_mode' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'medication_frequency' => ['required', 'string', 'max:255']
        ]);

        $prescription = Prescriptions::create([
            'medication_name' => $request->medication_name,
            'medication_mode' => $request->medication_mode,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth()->user()->id,
            'code' => Str::random(8),
            'medication_frequency' => $request->medication_frequency,
        ]);


        if(!$prescription){
        
            toastr()->error('Prescription could not be added, Try again later');
    
            return redirect()->back();
        }

        toastr()->success('Prescription Added Successfully');

        return redirect()->back();
    }

    public function update_prescription(Request $request){
        $request->validateWithBag('prescriptionUpdate', [
            'code' => ['required', 'string', 'max:255'],
            'medication_name' => ['required', 'string', 'max:255'],
            'medication_mode' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'medication_frequency' => ['required', 'string', 'max:255']
        ]);
    
        $code = $request->code;
    
        $prescription = Prescriptions::where('code', $code)->first();
    
        dd($prescription);
        // if (!$prescription) {
        //     toastr()->error('Sorry, Prescription could not be found');
        //     return redirect()->back();
        // }
        
        // $update_prescription = $prescription->update([
        //     'medication_name' => $request->medication_name,
        //     'medication_mode' => $request->medication_mode,
        //     'start_date' => $request->start_date,
        //     'end_date' => $request->end_date,
        //     'user_id' => auth()->user()->id,
        //     'medication_frequency' => $request->medication_frequency,
        // ]);
    
        // if (!$update_prescription) {
        //     toastr()->error('Prescription could not be updated');
        //     return redirect()->back();
        // }
    
        // toastr()->success('Prescription Updated Successfully');
        // return redirect()->back();
    }
    

    public function remove_prescription(Request $request){

        $request->validateWithBag('prescriptionDeletion', [
            'code' => ['required', 'string', 'max:255']
        ]);

        $code = $request->code;

        $prescription = Prescriptions::where('code',$code);

        if(!$prescription){

            toastr()->error('Sorry Prescription could not be found');
    
            return redirect()->back();
        }


        $delete_prescription = $prescription->delete();

        // $title = 'Delete User!';
        // $text = "Are you sure you want to delete?";

        // confirmDelete($title, $text);


        if(!$delete_prescription){

            toastr()->error('Prescription could not be deleted');
    
            return redirect()->back();
        }

        toastr()->success('Prescription Deleted Successfully');
    
        return redirect()->back();
    }
}