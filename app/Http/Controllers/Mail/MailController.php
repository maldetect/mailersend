<?php

namespace App\Http\Controllers\Mail;

use App\Events\NewEmailEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMailRequest;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;
use App\Models\Email;
use App\Services\EmailService;

class MailController extends Controller
{

    public function send(SendMailRequest $request)
    {
        $mails = $request->validated();
        foreach ($mails['mail'] as $key => $mail) {
            try {
                $email = EmailService::store($mail);
            } catch (\Exception $e) {
                return response()->json(['success' => 'false', 'message' => 'An error occurred during processing']);
            }
            event(new NewEmailEvent($email));
            Log::info('Dispatched emails ' . $email->id_email);
        }
        return response()->json(['success' => 'true', 'message' => 'Dispatched emails']);
    }


    public function list($offset, $search = null)
    {

        if ($search) {
            $emails = Email::with('attachments')
                ->search($search)
                ->pages($offset)->orderBy('id_email', 'desc')->get();
        } else {
            $emails = Email::with('attachments')
                ->pages($offset)->orderBy('id_email', 'desc')->get();
        }
        return response()->json([
            'success' => 'true',
            'data' => $emails
        ]);
    }
}
