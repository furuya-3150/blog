<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddresseeRequest extends FormRequest
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
			'name' => 'required|max:255',
			'postal_code' => 'required|regex:/^[0-9]{3}-[0-9]{4}+$/',
			'prefectures' => 'required|regex:/^.+[都道府県]$/',
			'municipalities' => 'required|regex:/^.+?[市区町村]$/',
			'address' => 'required|max:255',
			'telephone_number' => 'required|regex:/^0\d{2,3}-\d{1,4}-\d{4}$/',
        ];
	}

	public function messages() {
		return [
			'postal_code.regex' => '郵便番号を入力内容を確認してください。また、ハイフンを入れて入力してください。',
			'prefectures.regex' => '都道府県名の入力内容を確認してください',
			'municipalities.regex' => '市区町村名の入力内容を確認してください',
			'telephone_number.regex' => '電話番号の入力内容を確認してください。また、ハイフンを入れてください。'
		];

	}
}
