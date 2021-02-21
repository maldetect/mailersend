<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Email;
use App\Models\Attachment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AttachmentModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test  */
    public function check_if_attachment_columns_is_correct()
    {
        $attachment =  new Attachment();

        $expected = [
            'base64',
            'filename',
            'emails_id_email'

        ];

        $arrayCompared = array_diff($expected, $attachment->getFillable());
        $this->assertEquals(0, count($arrayCompared));
    }

    /** @test */
    public function an_attachment_belongs_to_email()
    {
        $email = Email::factory()->create();
        $attachment = Attachment::factory()->create(['emails_id_email' => $email->id_email]);



        // Method 1:
        $this->assertInstanceOf(Email::class, $attachment->email);
        // Method 2:
        $this->assertEquals(1, $attachment->email->count());
    }
}
