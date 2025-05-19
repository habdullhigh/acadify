<?php
namespace App\Http\Requests;

use App\Enums\RolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', Password::defaults()],
            'user_type' => ['required', new Enum(RolesEnum::class)],

            'matric_no' => [
                Rule::requiredIf(fn () => $this->user_type === RolesEnum::STUDENT->value),
                'nullable',
                'string',
                'unique:users,matric_no',
            ],
            'office_id' => [
                Rule::requiredIf(fn () => $this->user_type === RolesEnum::ADMIN->value),
                'nullable',
                'exists:offices,id',
            ],
        ];
    }
}
