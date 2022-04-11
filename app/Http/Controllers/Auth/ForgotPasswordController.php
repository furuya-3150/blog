<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
	use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
	}

	public function sendResetLinkEmail(Request $request)
	{
		$this->validateEmail($request);
		$response = $this->broker()->sendResetLink(
			$request->only('email')
		);
		return back()->with('status', 'パスワード再設定用のURLをメールで送りました。');
	}

}
