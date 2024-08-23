<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=> ['required', 'alpha' , 'min:6' , 'max:10'],
            'email'=> ['required', 'email'],
            'password'=> 'required'
        ];
    }

    /**
     * Set the validation massages that apply to the request.
     *
     *
     */

    public function messages(){
        return [
            'name.required' => 'User không được để trống',
            'name.alpha' => 'User name should only countain letters!',
            'email.required' => 'Email should only countain letters!',
        ];
    }
}
