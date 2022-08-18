<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'email' => ['required', 'email:rfc,dns'],
            'avatar' => 'required|string|max:255',
            'address' => 'required|string|',
            'phone_number' => 'required|string|min:11|max:20',
            'is_marketing' => 'nullable|size:1|digits:1',
        ];
    }
}
