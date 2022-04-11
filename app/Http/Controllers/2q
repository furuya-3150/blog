<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\EmailReset;
use App\Http\Requests\UserRequest;
use Carbon\Carbon;

class UserController extends Controller
{
	public function edit($user_id) {
		if ($user_id == Auth::id()) {
			return view('user.edit', ['user' => Auth::user()]);
		} else {
			return redirect(route('item.index'))->with('flash_message', '不正アクセス');
		}
	}

	public function update(UserRequest $request) {
		$check_pass = $this->checkpass($request);
		$user = User::where('id', Auth::id())->first();
		if ($check_pass == false) {
			return redirect(route('item.index'))->with('flash_message', '現在のパスワードと一致しません');
		}
		if (isset($request->password)) {
			$hashed = Hash::make($request->password);
			$user->password = $hashed;
		}
		$user->name = $request->name;
		$user->save();
		if ($request->email !== $user->email) {
			$this->sendChangeEmailLink($request);
			return redirect(route('item.index'))->with('flash_message', '更新し,確認メールを送信しました');
		}
		return redirect(route('item.index'))->with('flash_message', '更新しました');
	}

	public function checkPass($request) {
		$password = Auth::user()->password;
		if (Hash::check($request->input('now_password'), $password)) {
			return true;
		}
		return false;
	}

	public function sendChangeEmailLink($request) {
		$new_email = $request->email;
		$token = hash_hmac(
			'sha256',
			Str::random(40) . $new_email,
			config('app.key')
		);
		EmailReset::insert([
			'new_email' => $new_email,
			'token' => $token,
			'user_id' => Auth::id()
		]);
		$email_reset = new EmailReset;
		$email_reset->sendEmailResetNotification($token);
	}

	public function reset(Request $request, $token) {
		$email_resets = EmailReset::where('token', $token)->first();
		if (isset($email_resets) && !$this->tokenExpired($email_resets->created_at)) {
			$user = User::find($email_resets->user_id);
			$user->email = $email_resets->new_email;
			$user->save();
			$email_resets->delete();
			return redirect(route('item.index'))->with('flash_message', 'メールアドレスを更新しました');
		} else {
			if (isset($email_resets)) {
				$email_resets->delete();
			}
			return redirect(route('item.index'))->with('flash_message', 'メールアドレスの更新に失敗しました');
		}
	}
	protected function tokenExpired($createdAt)
	{
		$expires = 60 * 60;
		return Carbon::parse($createdAt)->addSeconds($expires)->isPast();
	}
}
