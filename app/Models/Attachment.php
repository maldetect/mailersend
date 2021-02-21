<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_attachment';
    protected $table      = 'attachments';

    /**
     * @var array
     */
    protected $fillable = [
        'base64',
        'filename',
        'emails_id_email'


    ];
    public function email()
    {
        return $this->belongsTo('App\Models\Email', 'emails_id_email');
    }
}
