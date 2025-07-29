<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Визначте, чи має користувач право робити цей запит.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Отримайте правила перевірки, які застосовуються до запиту.
     */
    public function rules(): array
    {
        return [
            // Вказуємо назви полів форми
            'title' => 'required|max:255', // required - потрібно
            'description' => 'required',
            'long_description' => 'required'
        ];
    }
}
