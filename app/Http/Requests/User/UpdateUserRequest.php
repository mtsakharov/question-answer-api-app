<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'avatar' => 'mimes:jpeg,bmp,png|required',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed|required|min:8'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required!',
            'avatar.required' => 'Avatar is required!',
            'email.required' => 'Email is required!',
            'password.required' => 'Password is required!'
        ];
    }
}
