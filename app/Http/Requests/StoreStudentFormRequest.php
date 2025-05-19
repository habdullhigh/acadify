<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStudentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user is authenticated and has the 'student' role
        return Auth::check() && auth()->user->isStudent();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'office_id' => 'required|exists:offices,id',
            'user_id' => 'required|exists:users,id',
            'form_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',

        ];
    }
}
