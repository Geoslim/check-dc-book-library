<?php

namespace App\Http\Requests\Admin\AccessLevel;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccessLevelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:access_levels,name',
            'min_age' => 'required|numeric',
            'max_age' => 'required|numeric',
            'lending_point' => 'required|numeric'
        ];
    }
}
