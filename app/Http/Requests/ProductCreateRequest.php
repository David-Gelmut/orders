<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'category_id' => ['required'],
            'description' => [],
            'price' => ['required', 'decimal:2']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле Название обязательно для заполнения',
            'category_id.required' => 'Поле Категория обязательно для заполнения',
            'price.required' => 'Поле Цена обязательно для заполнения',
            'price.decimal' => 'Поле Цена имеет числовой тип и два знака после запятой'
        ];
    }
}
