<?php

namespace App\Http\Requests\Text;

use Illuminate\Foundation\Http\FormRequest;

class StoreTextRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => [
                'required',
                'string',
            ],
        ];
    }
}
