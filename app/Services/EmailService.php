<?php

namespace App\Services;

use DB;
use App\Models\Attachment;
use App\Models\Email;

class EmailService
{

    public static function store($mail)
    {
        DB::beginTransaction();
        try {
            $mail['status'] = config('constants.STATUS_EMAIL.POSTED');
            $email = Email::create($mail);
            if (isset($mail['attachments'])) {
                foreach ($mail['attachments'] as $attachment) {
                    $attachmentModel = new Attachment($attachment);
                    $email->attachments()->save($attachmentModel);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        return $email;
    }
}
