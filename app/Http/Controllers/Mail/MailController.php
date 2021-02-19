<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;
use App\Models\Email;
use App\Models\Attachment;

class MailController extends Controller
{

    public function send(Request $request)
    {


        $mails = $request->all();

        $validator = Validator::make($mails, [
            'mail' => 'required|array',
            'mail.*.subject' => 'required|string',
            'mail.*.to' => 'required|email',
            'mail.*.from' => 'required|email',
            'mail.*.text_content' => 'required|string',
            'mail.*.html_content' => 'required|string',
            'mail.*.attachments' => 'nullable|array',
            'mail.*.attachments.*.base64' => 'required_with:mail.*.attachments|base64',
            'mail.*.attachments.*.filename' => 'required_with:mail.*.attachments',
        ]);

        if ($validator->fails()) {
            $response = [
                'errors' => $validator->messages(),
                'success' => 'false',

            ];
            return response()->json($response, 422);
        }
        DB::beginTransaction();
        try{

            foreach($mails['mail'] as $key => $mail){
                $mail['status']="Posted";

                $email = Email::create($mail);
                $mails['mail'][$key]['id_email']=$email->id_email;
                if (isset($mail['attachments'])){

                    foreach ($mail['attachments'] as $attachment){
                        $attachment['emails_id_email'] =$email->id_email;
                        $attachment = Attachment::create($attachment);
                    }
                }

            }

        }catch(\Exception $e){
            DB::rollback();
            $response = [
                'errors' => 'An error occurred during processing!',
                'success' => 'false',

            ];
            return response()->json($response, 422);
        }
        DB::commit();

        foreach ($mails['mail'] as $key => $mail) {
            SendEmail::dispatch($mail)->onQueue('email');;

            Log::info('Dispatched emails ' . $mail['id_email']);
        }


        return response()->json(['success' => 'true', 'message' => 'Dispatched emails']);
    }


    public function list($offset,$search=null)
    {


        if ($search){
            $emails = Email::with('attachments')->where('to','ilike','%'.$search.'%')
                ->orWhere('from','ilike','%'.$search.'%')
                ->orWhere('subject','ilike','%'.$search.'%')
                ->offset($offset*5)->limit(5)->orderBy('id_email','desc')->get();
        }else{
            $emails = Email::with('attachments')
                ->offset($offset*5)->limit(5)->orderBy('id_email','desc')->get();
        }
        return response()->json([
            'success'=>'true',
            'data'=>$emails
        ]);
    }
}
