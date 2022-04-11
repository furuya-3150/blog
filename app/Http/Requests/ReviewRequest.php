<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
			'rate' => 'required',
			'comment' => 'nullable|max:256'
        ];
	}

	public function messages() {
		return [
			'rate.required' => '五段階評価お願いします',
			'comment.nullable' => 'コメントは256文字以内で入力してください'
		];
	}
}
