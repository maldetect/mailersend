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

            $job = json_decode($event->job->getRawBody(), true);
            $mail = (unserialize(json_decode($event->job->getRawBody(), true)['data']['command']));
            Log::info($mail->email['id_email']);
            $email = Email::findOrFail($mail->email['id_email']);
            if ($email->isPosted()) {
                $email->status = config("constants.STATUS_EMAIL.SENT");
                $email->save();
            }
        });
    }
}
