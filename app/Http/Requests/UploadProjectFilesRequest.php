<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadProjectFilesRequest extends FormRequest
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
            'files.*'     => 'required|mimes:jpeg,bmp,png,jpg,zip,tar,gzip,txt,xlsx,docx,pptx,pdf|max:2000',
        ];
    }
}
