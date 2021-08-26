<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' => ['required', 'max:60', Rule::unique('products')->ignore($this->product)],
            'product_code' => ['required', 'max:20', Rule::unique('products')->ignore($this->product)],
            'product_quantity' => 'required|numeric',
            'discount_price' => 'numeric|nullable',
            'category_id' => 'required|numeric',
            'subcategory_id' => 'numeric|nullable',
            'brand_id' => 'numeric|nullable',
            'product_size' => 'nullable',
            'product_color' => 'required',
            'selling_price' => 'required|numeric',
            'product_details' => 'required|min:30',
            'video_link' => 'max:60',
            'main_slider' => 'boolean',
            'hot_deal' => 'boolean',
            'best_rated' => 'boolean',
            'trend' => 'boolean',
            'mid_slider' => 'boolean',
            'hot_new' => 'boolean',
            'status' => 'boolean',
            'cover' => 'required_without:id|file|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'image' => 'required_without:id',
            'image.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'cover.required_without' => 'The cover field is required'
        ];
    }
}