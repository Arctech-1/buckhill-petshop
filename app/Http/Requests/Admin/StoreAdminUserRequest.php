<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreAdminUserRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', Password::min(8)->mixedCase()],
            'avatar' => 'required|string|max:255',
            'address' => 'required|string|',
            'phone_number' => 'required|string|min:11|max:20',
            'marketing' => 'nullable|size:1|digits:1',
        ];
    }
}
