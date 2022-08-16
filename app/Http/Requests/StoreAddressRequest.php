<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "postal_code" => "required|digits:8",
            "street" => "required|max:70",
            "number" => "max:10",
            "complement" => "max:70",
            "district" => "required|max:70",
            "city" => "required|max:70",
            "state" => "required|max:70",
            "country" => "required|max:70",
        ];
    }
}
