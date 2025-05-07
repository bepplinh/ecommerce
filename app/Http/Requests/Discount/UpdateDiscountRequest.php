<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
        $discountId = $this->route('discount');
        return [
            'name' => 'required|string|max:255|unique:discounts,name,' . $discountId,
            'value' => 'required|numeric|min:0',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên mã giảm giá.',
            'name.unique' => 'Tên mã giảm giá đã tồn tại.',
            'name.max' => 'Tên mã giảm giá không được vượt quá 255 ký tự.',

            'value.required' => 'Vui lòng nhập giá trị giảm giá.',
            'value.numeric' => 'Giá trị giảm giá phải là số.',
            'value.min' => 'Giá trị giảm giá phải lớn hơn hoặc bằng 0.',

            'start_at.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_at.date' => 'Ngày kết thúc không hợp lệ.',
            'end_at.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ];
    }
}
