<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;

class AttachmentSchemaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test  */
    public function attachments_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('attachments', [
                'id_attachment', 'emails_id_email', 'base64', 'filename', 'created_at', 'updated_at'
            ]),
            1
        );
    }
}
