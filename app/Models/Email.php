<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_email';
    protected $table      = 'emails';

    /**
     * @var array
     */
    protected $fillable = [
        'to',
        'from',
        'subject',
        'text_content',
        'html_content',
        'status'

        ];

    public function attachments(){
        return $this->hasMany('App\Models\Attachment','emails_id_email');
    }

}
