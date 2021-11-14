<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

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
            'sku' => ['required', 'max:20', Rule::unique('products')->ignore($this->product)],
            'product_quantity' => 'required|numeric',
            'discount_price' => 'numeric|nullable',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'product_size' => 'nullable',
            'product_color' => 'required',
            'selling_price' => 'required|numeric',
            'product_details' => 'required|min:30',
            'video_link' => 'max:60',
            'status' => [new EnumRule(ProductStatus::class)],
            'cover' => 'required_without:id|file|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'image' => 'required_without:id',
            'image.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'cover.required_without' => 'The cover field is required',
            'image.required_without' => 'The image field is required'
        ];
    }
}
