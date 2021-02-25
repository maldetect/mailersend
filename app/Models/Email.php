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

    public function attachments()
    {
        return $this->hasMany('App\Models\Attachment', 'emails_id_email');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('to', 'ilike', '%' . $search . '%')
            ->orWhere('from', 'ilike', '%' . $search . '%')
            ->orWhere('subject', 'ilike', '%' . $search . '%');
    }

    public function scopePages($query, $offset)
    {
        return $query->offset($offset * 5)->limit(5);
    }

    public function isPosted()
    {
        return $this->status == config('constants.STATUS_EMAIL.POSTED');
    }
}
