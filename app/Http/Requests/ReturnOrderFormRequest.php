<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ReturnOrderFormRequest extends FormRequest
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
            'order_items' => 'required|array',
            'order_items.*' => 'required|numeric|distinct',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric',
            'billing_address' => 'required|numeric',
            'shipping_address' => 'required|numeric',
            'payment_method' => 'required|string',
            'rate_object_id' => 'required',
            'order_id' => 'required|numeric',
            'reason' => 'required|numeric',
            'details' => 'nullable|string|max:5000',
        ];
    }
}