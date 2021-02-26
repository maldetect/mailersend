<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mail' => 'required|array',
            'mail.*.subject' => 'required|string|max:255',
            'mail.*.to' => 'required|email',
            'mail.*.from' => 'required|email',
            'mail.*.text_content' => 'required|string',
            'mail.*.html_content' => 'required|string',
            'mail.*.attachments' => 'nullable|array',
            'mail.*.attachments.*.base64' => 'required_with:mail.*.attachments|base64',
            'mail.*.attachments.*.filename' => 'required_with:mail.*.attachments',
        ];
    }

    public function response(array $errors)
    {

        return response()->json(['success' => 'false', 'errors' => $errors], 422);
    }
}
