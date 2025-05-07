<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class CreateDiscountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:discounts,name|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if (request('type') === 'percentage' && $value > 100) {
                        $fail('Giá trị phần trăm không được vượt quá 100%.');
                    }
                },
            ],
            'start_at' => 'nullable|date|after_or_equal:today',
            'end_at' => 'nullable|date|after:start_at',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên mã giảm giá không được để trống',
            'name.unique' => 'Tên mã giảm giá đã tồn tại',
            'name.max' => 'Tên mã giảm giá không được vượt quá 255 ký tự',
            'type.required' => 'Loại giảm giá không được để trống',
            'type.in' => 'Loại giảm giá không hợp lệ',
            'value.required' => 'Giá trị không được để trống',
            'value.numeric' => 'Giá trị phải là số',
            'value.min' => 'Giá trị phải lớn hơn hoặc bằng 0',
            'start_at.date' => 'Ngày bắt đầu không hợp lệ',
            'start_at.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi',
            'end_at.date' => 'Ngày kết thúc không hợp lệ',
            'end_at.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
            'status.required' => 'Trạng thái không được để trống',
            'status.in' => 'Trạng thái không hợp lệ',
        ];
    }

    
}