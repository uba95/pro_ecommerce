<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($this->admin)],
            'phone' => ['required', 'string', 'max:255', Rule::unique('admins')->ignore($this->admin)],
            'avatar' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
            'password' => ['required_without:id', 'string', 'min:8', 'confirmed'],
            'roles' => ['required'],
        ];
    }
}
