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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'phone' => 'nullable|regex:/^([+]\d{2,3})?\s*\d{3}\s*\d{3}\s*\d{3}$/',
            'email' => 'required|string|email|max:255|unique:users',
            'profile_photo' => 'nullable|mimes:jpg,png|unique:users,profile_photo',
            'password' => 'required|string|min:3|confirmed',
        ];
    }
}
