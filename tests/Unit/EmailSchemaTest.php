<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;

class EmailSchemaTest extends TestCase
{
    use RefreshDatabase, WithFaker;



    /** @test  */
    public function emails_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('emails', [
                'id_email', 'to', 'from', 'subject', 'text_content', 'html_content', 'status', 'created_at', 'updated_at'
            ]),
            1
        );
    }
}
