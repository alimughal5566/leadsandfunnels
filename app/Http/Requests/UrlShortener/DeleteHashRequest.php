<?php

namespace App\Http\Requests\UrlShortener;

use Illuminate\Foundation\Http\FormRequest;

class DeleteHashRequest extends FormRequest
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
//            'id' => 'required|exists:lynxly_links,id',
            'id' => 'required|numeric|exists:clients_leadpops,id',
        ];
    }
}
