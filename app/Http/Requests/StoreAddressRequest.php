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
            "street" => "required|min:3",
            "number" => "max:10",
            "complement" => "min:3",
            "district" => "required|min:3",
            "city" => "required|min:3",
            "state" => "required|size:2",
            "country" => "required|min:3",
        ];
    }
}
