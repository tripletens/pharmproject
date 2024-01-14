<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prescriptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\MedicationEmail;
use App\Models\User;

class MedicationEmailCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:medication-email-cron-job {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails for each prescriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the ID of the authenticated user if available
        $userId = $this->argument('user_id');
        

        // Check if the user ID is provided
        if (!$userId) {
            $this->error('User ID not provided.');
            return;
        }

        $user_email = User::find($userId)->email;

        $user_name = User::find($userId)->name; 

        // Now you can use $userId to fetch prescriptions for the specific user
        $userPrescriptions = DB::table('prescription')->where('user_id', $userId)->get();

        // 'medication_name','user_id','medication_mode','code', 'start_date', 'end_date', 'medication_frequency','daily_time'

        // Perform actions based on prescriptions

        // loop through the prescriptions 

        foreach ($userPrescriptions as $prescription) {
            $medication_name = $prescription->medication_name;
            $medication_code = $prescription->code;
            $start_date = $prescription->start_date;
            $end_date = $prescription->end_date;
            $daily_time = $prescription->daily_time;
            $medication_frequency = $prescription->medication_frequency;
 
            $prescription->email = $user_email ?? null;

            $prescription->name = $user_name ?? null;
            
            Mail::to($user->email)->later($scheduledTime, new MedicationEmail($prescription));

            
            // Check if today is within the prescription period
            if (now()->between($start_date, $end_date)) {
                // If daily_time is set, check if it's time to send the email
                if ($daily_time) {
                    $dailyTimeToCompare = now()->setTimeFromTimeString($daily_time);
                    if (now()->greaterThanOrEqualTo($dailyTimeToCompare)) {
                        $this->sendMedicationEmail($prescription);
                    }
                } else {
                    // If daily_time is not set, send emails based on medication_frequency
                    switch ($medication_frequency) {
                        case 'once_daily':
                            $this->sendMedicationEmail($prescription);
                            break;

                        case 'twice_daily':
                            $this->sendMedicationEmail($prescription);
                            $this->sendMedicationEmail($prescription, 12); // Send second email 12 hours later
                            break;

                        case 'thrice_daily':
                            $this->sendMedicationEmail($prescription);
                            $this->sendMedicationEmail($prescription, 6); // Send second email 8 hours later
                            $this->sendMedicationEmail($prescription, 12); // Send third email 16 hours later
                            break;

                        case 'once_eight_hours':
                            $this->sendMedicationEmail($prescription);
                            $this->sendMedicationEmail($prescription, 8); // Send second email 8 hours later
                            break;

                        default:
                            // Handle other cases if needed
                            break;
                    }
                }
            }
        }

        $this->info('Your cron job has run successfully!');
    }

    private function sendMedicationEmail($prescription, $hoursLater = 0)
    {
        // Modify this function to send the actual email using Laravel Mail
        // You may need to create a Mailable class for your email
        $user = User::find($this->argument('user_id'));

        if ($user) {
            $scheduledTime = now()->addHours($hoursLater);
            Mail::to($user->email)->later($scheduledTime, new MedicationEmail($prescription));

            $receiver = $user->phone; // Replace with the actual recipient's phone number

            $message = 'Hello ' . $user->name . 
                ', This is a reminder to take your medication ' . $medication_name . ' \n It started on ' . $start_date . ' and is expected to end on ' . $end_date ;

            // Create an instance of TwilioServiceController
            $twilioController = new TwilioServiceController();
            
            // Call the sendSms method on the instance
            $sendSms = $twilioController->send_sms($receiver, $message);

        } else {
            $this->error('User not found.'); // Handle the case where the user is not found
        }
    }
}
