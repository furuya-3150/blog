<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Addressee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	public function index() {
		$users = User::all();
		return view('admin.user.index', ['users' => $users]);
	}

	public function detail($id) {
		$user = User::where('id', $id)->first();
		if (empty($user)) {
			return redirect(route('admin.user.index'))->with('flash_message', '不正アクセス');
		}
		$addressee = Addressee::where('user_id', $id)->whereNotNull('select')->first();
		return view('admin.user.detail', ['user' => $user, 'addressee' => $addressee]);
	}
}
