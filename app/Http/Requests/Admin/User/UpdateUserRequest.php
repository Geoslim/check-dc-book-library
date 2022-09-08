<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Auth\ProfileUpdateRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        return array_merge((new ProfileUpdateRequest())->rules(), [
            'role_id' => 'required|array|exists:roles,id',
        ]);
    }
}
