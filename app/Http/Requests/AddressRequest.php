<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => 'required||max:30',
            'address_1' => 'required|max:100',
            'address_2' => 'nullable|max:100',
            'zip' => 'nullable|numeric',
            'city' => 'required|max:100',
            'country_id' => 'required|numeric',
            'status' => 'nullable',
            'phone' => 'nullable|max:20',
        ];
    }
}

