<?php

namespace Tests\Unit;

use App\Jobs\SendEmail;
use App\Mail\MyMail;
use App\Models\Email;
use App\Models\Attachment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Mail;
use DB;

class MyMailTest extends TestCase
{
    private $mail;



    function __construct()
    {
        parent::__construct();
        $this->mail = [
            'mail' => [
                0 => [
                    'subject' => 'subject from test',
                    'from' => 'from@test.com',
                    'to' => 'to@test.com',
                    'text_content' => 'text content',
                    'html_content' => 'HTML content',
                    'attachments' => [
                        0 => [
                            'base64' => base64_encode('dfsgdfFgsdfgbxcvTRT'),
                            'filename' => 'filename.jpg'

                        ]
                    ]
                ]
            ]
        ];;
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_email_successful_queued()
    {
        Mail::fake();
        $mail = $this->mail;
        $response = $this->post('/api/send', $mail);
        $response->assertStatus(200)
            ->assertJson([
                'success' => 'true', 'message' => 'Dispatched emails'
            ]);

        Mail::assertQueued(MyMail::class);
    }

    public function test_email_dispatched()
    {
        Queue::fake();

        $mail = $this->mail;
        $mail['mail'][0]['status'] = 'Posted';
        $email = Email::create($mail['mail'][0]);
        $mail['mail'][0]['id_email'] = $email->id_email;

        SendEmail::dispatch($mail['mail'][0])->onQueue('email');

        Queue::assertPushedOn('email', SendEmail::class);
        Queue::assertPushed(function (SendEmail $job) use ($mail) {
            $json = json_encode($mail['mail'][0]);

            $json2 = json_encode($job->mail);

            return $json == $json2;
        });
    }

    public function test_email_failed()
    {
        Queue::fake();

        $mail = $this->mail;
        $mail['mail'][0]['status'] = 'Posted';
        $email = Email::create($mail['mail'][0]);
        $mail['mail'][0]['id_email'] = $email->id_email;

        SendEmail::dispatch($mail['mail'][0])->onQueue('email');



        Queue::assertPushedOn('email', SendEmail::class);
        Queue::assertPushed(function (SendEmail $job) use ($mail) {
            $job->failed(new \Exception());
            $email = Email::findOrFail($job->mail['id_email']);

            return $email->status == 'Failed';
        });
    }

    public function test_email_build()
    {
        Mail::fake();

        $mail = $this->mail;
        $mail = new MyMail($this->mail['mail'][0]);


        $this->assertInstanceOf(MyMail::class, $mail->build());
    }

    public function test_post_more_than_one_email_queued()
    {
        Mail::fake();
        $mail1 = $this->mail;
        $mail2 = $this->mail;

        $mail1['mail'][0]['subject'] = "mail1";
        $mail2['mail'][0]['subject'] = "mail2";
        array_push($mail1['mail'], $mail2['mail'][0]);
        $response = $this->post('/api/send', $mail1);
        $response->assertStatus(200);

        Mail::assertQueued(MyMail::class);
    }

    public function test_subject_is_required()
    {
        $mail = $this->mail;
        unset($mail['mail'][0]['subject']);
        $response = $this->post('/api/send', $mail);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mail.0.subject']);
    }

    public function test_from_is_required()
    {
        $mail = $this->mail;
        unset($mail['mail'][0]['from']);
        $response = $this->post('/api/send', $mail);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mail.0.from']);
    }

    public function test_email_without_attachments_queued()
    {
        Mail::fake();
        $mail = $this->mail;
        unset($mail['mail'][0]['attachments']);

        $response = $this->post('/api/send', $mail);
        $response->assertStatus(200);

        Mail::assertQueued(MyMail::class);
    }

    public function test_filename_is_required_if_has_attachments()
    {
        $mail = $this->mail;
        unset($mail['mail'][0]['attachments'][0]['filename']);
        $response = $this->post('/api/send', $mail);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mail.0.attachments.0.filename']);
    }

    public function test_base64_is_required_if_has_attachments()
    {
        $mail = $this->mail;
        unset($mail['mail'][0]['attachments'][0]['base64']);
        $response = $this->post('/api/send', $mail);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mail.0.attachments.0.base64']);
    }

    public function test_to_is_required()
    {
        $mail = $this->mail;
        unset($mail['mail'][0]['to']);
        $response = $this->post('/api/send', $mail);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mail.0.to']);
    }

    public function test_text_content_is_required()
    {
        $mail = $this->mail;
        unset($mail['mail'][0]['text_content']);
        $response = $this->post('/api/send', $mail);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mail.0.text_content']);
    }

    public function test_html_content_is_required()
    {
        $mail = $this->mail;
        unset($mail['mail'][0]['html_content']);
        $response = $this->post('/api/send', $mail);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mail.0.html_content']);
    }



    public function test_base64_validation()
    {
        $mail = $this->mail;
        $mail['mail'][0]['attachments'][0]['base64'] = "#%8sd%76";
        $response = $this->post('/api/send', $mail);

        $response->assertStatus(422);
        $response->assertExactJson(['errors' =>
        [
            'mail.0.attachments.0.base64' => [0 => 'validation.base64'],

        ], 'success' => 'false']);
    }

    public function test_list_jobs()
    {

        $response = $this->get('/api/list/0/');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',  'success'
        ]);
    }

    public function test_list_jobs_witch_search()
    {

        $response = $this->get('/api/list/0/from');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',  'success'
        ]);
    }
}
