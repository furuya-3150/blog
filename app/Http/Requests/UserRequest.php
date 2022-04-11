<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
		$user_id = Auth::id();
		return [
			'name' => 'required|max:256',
			'email' => 'required|unique:users,email,' . $user_id . '|email|max:256',
			'password' => 'nullable|min:8|max:256|confirmed',
			'password_confirmation' => 'nullable|min:8|max:256',
			'now_password' => 'required|min:8|max:256'
        ];
    }
}
