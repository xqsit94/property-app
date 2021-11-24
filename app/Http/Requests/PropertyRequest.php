<?php

namespace App\Http\Requests;

use App\Rules\CheckMainOwnerRule;
use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            "address" => "required|string|max:250",
            "postcode" => "required|string|max:10",
            "owners" => "required|array",
            "owners.*" => "exists:users,id",
            "main_owner" => [
                "required",
                "exists:users,id",
                new CheckMainOwnerRule($this->get("owners")),
            ],
        ];
    }

    public function messages()
    {
        return [
            "owners.array" => "This :attribute must be array of owner ids",
        ];
    }
}
