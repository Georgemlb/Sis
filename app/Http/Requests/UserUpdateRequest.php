<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var User|null $user */
        $user = $this->route('user');

        if ($user === null) {
            return false;
        }

        return $this->user()?->can('update', $user) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = $this->route('user');

        return [
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class, 'username')->ignore($user->id)],
            'account_type' => ['required', 'string', 'in:admin,student,staff,teacher'],
            'password' => ['nullable', 'string', 'confirmed'],
        ];
    }
}
