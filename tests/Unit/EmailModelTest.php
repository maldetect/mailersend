<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Email;
use App\Models\Attachment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class EmailModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test  */
    public function check_if_email_columns_is_correct()
    {
        $email =  new Email();

        $expected = [
            'to',
            'from',
            'subject',
            'text_content',
            'html_content',
            'status'

        ];

        $arrayCompared = array_diff($expected, $email->getFillable());
        $this->assertEquals(0, count($arrayCompared));
    }

    /** @test */
    public function an_email_has_many_attachment()
    {
        $email = Email::factory()->create();
        $attachment = Attachment::factory()->create(['emails_id_email' => $email->id_email]);



        // Method 1:
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $email->attachments);
        // Method 2:
        $this->assertTrue($email->attachments->contains($attachment));
        // Method 3:
        $this->assertEquals(1, $email->attachments->count());
    }
}
