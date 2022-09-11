<?php

namespace App\Http\Requests\Admin\AccessLevel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateAccessLevelRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return array_merge((new CreateAccessLevelRequest())->rules(), [
            'name' => [
                'required',
                Rule::unique('access_levels')
                    ->ignore($request->route('accessLevel'))
            ]
        ]);
    }
}
