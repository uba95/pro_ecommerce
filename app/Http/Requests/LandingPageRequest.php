<?php

namespace App\Http\Requests;

use App\Enums\LandingPageItemStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

class LandingPageRequest extends FormRequest
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
        // dd($this->all());
        return [
            'product_id' => 'required_without:is_advert|exists:products,id',

            'is_main_banner' => 'boolean',
            'main_banner_text' => 'required_with:is_main_banner|max:50',
            'main_banner_img' => [Rule::requiredIf(!$this->item && $this->is_main_banner), 'file', 'mimes:jpeg,png,jpg,gif,svg'],

            'is_banner_slider' => 'boolean',
            'banner_slider_text' => 'required_with:is_banner_slider|max:200',
            'banner_slider_img' => [Rule::requiredIf(!$this->item && $this->is_banner_slider), 'file', 'mimes:jpeg,png,jpg,gif,svg'],

            'is_advert' => 'boolean',
            'advert_headline' => 'required_with:is_advert|max:20',
            'advert_text' => 'required_with:is_advert|max:80', 
            'advert_img' => [Rule::requiredIf(!$this->item && $this->is_advert), 'file', 'mimes:jpeg,png,jpg,gif,svg'],
            
            'status' => [new EnumRule(LandingPageItemStatus::class)],
        ];
    }

    public function messages()
    {
        return [
            'main_banner_text.required_with' => 'The main banner text field is required',
            'banner_slider_text.required_with' => 'The banner text field is required',
            'advert_headline.required_with' => 'The advert headline field is required',
            'advert_text.required_with' => 'The advert text field is required',
        ];
    }
}
