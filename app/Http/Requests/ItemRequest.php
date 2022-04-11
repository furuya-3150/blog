<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
	{
		$route = $this->route()->getName();
        $rules = [
			'name' => 'required|max:256',
			'image' => 'nullable|image',
			'description' => 'required|max:256',
			'stock' => 'required|regex:/^[0-9]{1,10}+$/'
		];
		switch($route) {
		case 'admin.createReceive':
			$rules['value'] = 'required|regex:/^[1-9][0-9]{0,9}+$/';
			break;
		}
		return $rules;
    }
}
