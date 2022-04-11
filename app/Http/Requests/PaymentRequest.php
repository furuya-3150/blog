<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			"stripeEmail" => "required|email|max:256",
			"stripeBillingName" => "required|max:256",
			"stripeBillingAddressLine1" => "required|regex:/^(.+?[都道府県])(.+?[市区町村])(.+)$/",
			"stripeBillingAddressZip" => "required|regex:/^[0-9]{3}-{0,1}[0-9]{4}+$/",
			"stripeBillingAddressCity" => "required|regex:/^.+[都道府県]$/",
			"stripeShippingName" => "required",
			"stripeShippingAddressLine1" => "required|regex:/^(.+?[都道府県])(.+?[市区町村])(.+)$/",
			"stripeShippingAddressZip" => "required|regex:/^[0-9]{3}-{0,1}[0-9]{4}+$/",
			"stripeShippingAddressCity" => "required|regex:/^.+[都道府県]$/",
		];
	}
	public function messages() {
		return [
			'stripeBillingAddressLine1.regex' => '正しい配送先住所を入力してください',
			'stripeBillingAddressZip.regex' => '正しい配送先の郵便番号を入力してください',
			'stripeBillingAddressCity.regex' => '配送先の都道府県名を正しく入力してください',
			'stripeShippingAddressLine1.regex' => '正しい請求先住所を入力してください',
			'stripeShippingAddressZip.regex' => '正しい請求先郵便番号を入力してください',
			'stripeShippingAddressCity.regex' => '請求先の都道府県名を正しく入力してください'
		];
	}
}
