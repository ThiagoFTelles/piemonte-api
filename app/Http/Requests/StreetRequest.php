<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StreetRequest extends FormRequest
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
            "street" => "required|digits_between:3,70",
            "state" => "required|digits:2",
            "city" => "required|digits_between:3,70",
        ];
    }
}
