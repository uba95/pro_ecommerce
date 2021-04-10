<?php

namespace App\Http\Requests;

use App\Enums\CouponStatus;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'coupon_name' => ['required', 'max:255', Rule::unique('coupons')->ignore($this->coupon)],
            'discount' => 'required|numeric|between:0,100',
            'status' =>  [new EnumRule(CouponStatus::class)],
            'max_use_count' => 'required|numeric',
            'started_at' => 'required|date|before:expired_at',
            'expired_at' => 'required|date',
        ];
    }
}
