<?php

namespace App\Http\Requests\Admin\Book;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBookRequest extends FormRequest
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
            'title' => 'required|unique:books,title',
            'edition' => 'required',
            'description' => 'required',
            'prologue' => 'required',
            'author_id' => [
                'required',
                'array',
                Rule::exists('role_user', 'user_id')
                    ->where(function ($query) {
                        $query->where(
                            'role_id',
                            Role::whereSlug('author')
                                ->select('id')
                            ->first()['id']
                        )->exists();
                    })
            ],
            'category_id' => 'required|array|exists:categories,id',
            'tag_id' => 'required|array|exists:tags,id',
            'access_level_id' => 'required|array|exists:access_levels,id',
            'plan_id' => 'required|array|exists:plans,id'
        ];
    }

    public function messages(): array
    {
        return [
            'author_id.exists' => 'Selected user needs to be an author.',
        ];
    }
}
