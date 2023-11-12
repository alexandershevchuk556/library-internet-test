<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $rules =  [
            'name' => 'required|string|unique:users|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required|string|max:255'
        ];

        switch ($this->getMethod()) {
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                    'id' => 'required|exists:users,id',
                    'email' => 'required', Rule::unique('users')->ignore($this->email, 'email'),
                    'password' => 'required|string|max:255'
                ];
            case 'DELETE':
                return [
                    'id' => 'required|integer|exists:users,id'
                ];
        }

        return $rules;
    }
}
