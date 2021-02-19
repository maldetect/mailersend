<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Log;
use App\Models\Email;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('base64', function ($attribute, $value, $parameters, $validator) {
            if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $value)) {
                return true;
            } else {
                return false;
            }
        });

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            $job= json_decode($event->job->getRawBody(),true);
            //$result = array_keys(json_decode($event->job->getRawBody(), true)['data']['command']);
            $mail = (unserialize(json_decode($event->job->getRawBody(), true)['data']['command']));
            foreach($mail as $r){

                Log::info($r);
            }
            Log::info($mail->mail['id_email']);
            $email = Email::find($mail->mail['id_email']);
            if ($email){
                if ($email->status=="Posted"){
                    $email->status="Sent";
                    $email->save();
                }

            }

        });

    }
}
