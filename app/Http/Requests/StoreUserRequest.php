<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'user_name' => 'required|max:255|unique:users',
            'gender' => 'required|in:male,female',
            'email' => 'required|regex:/^.+@.+$/i|unique:users|email',
            'password' => 'required|min:8',
            'phone' => 'required|regex:/^\+923\d{9}$/|unique:users',
        ];
    }
}
