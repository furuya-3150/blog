<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
	}

    public function rules()
    {
		return [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'content' => 'required'
        ];
    }

	public function messages() {
		return [
			'name' => '255文字以内で名前を入力してください',
			'email' => '正しいメールアドレスを入力してください',
			'content' => 'お問合せ内容を確認してください'
		];
	}

}
