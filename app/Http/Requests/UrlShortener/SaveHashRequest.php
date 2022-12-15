<?php

namespace App\Http\Requests\UrlShortener;

use Illuminate\Foundation\Http\FormRequest;

class SaveHashRequest extends FormRequest
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
            'clients_leadpops_id' => 'required|numeric|exists:clients_leadpops,id',
            'leadpop_id' => 'numeric|exists:leadpops,id',
            'client_id' => 'numeric|exists:clients,client_id',
            'slug_name' => 'required|min:2|unique:clients_leadpops,lynxly_hash',
            'target_url' => 'required|url'
        ];
    }
}
