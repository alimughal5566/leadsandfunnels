<?php

namespace App\Http\Requests\UrlShortener;

use Illuminate\Foundation\Http\FormRequest;

class EditHashRequest extends FormRequest
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


    public function messages()
    {
        return [
            'old_slug_name.exists' => 'Old slug does not exists'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'old_slug_name' => 'required|min:2|exists:clients_leadpops,lynxly_hash|different:new_slug_name',
            'new_slug_name' => 'required|min:2|unique:clients_leadpops,lynxly_hash|different:old_slug_name',
        ];
    }
}
