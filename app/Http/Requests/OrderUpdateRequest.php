<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'comment'=>['required','string'],
            'product_ids'=>['required','array'],
            'product_count'=>['required','integer'],
            'status'=>['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле Имя обязательно для заполнения',
            'product_ids.required'  => 'Поле Товары статьи обязательно для заполнения',
            'product_count.required' => 'Поле Количество товаров обязательно для заполнения',
            'created_date.date_format' => 'Поле Даты создания имеет неверный формат.Формат: Y-m-d',
            'created_date.required' => 'Поле Даты создания обязательно для заполнения'
        ];
    }
}
