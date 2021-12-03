<?php

namespace App\Http\Requests;

use App\Enums\HotDealStatus;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class HotDealRequest extends FormRequest
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
            'discount_price' => 'required|numeric',
            'status' =>  [new EnumRule(HotDealStatus::class)],
            'started_at' => 'required|date|before:expired_at',
            'expired_at' => 'required|date',
        ];
    }
}

