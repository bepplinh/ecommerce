<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'code' => 'required|string|max:50|unique:products,code',
            'description' => 'required|string|max:255',
            'price' => 'required|string',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'variants' => 'required|array', 
            'variants.*.color_id' => 'required|exists:colors,id', 
            'variants.*.size_id' => 'required|exists:sizes,id',  
            'variants.*.stock' => 'required|integer|min:0', 
        ];
    }
}
