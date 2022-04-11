<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;
use App\Notifications\ContactNotification;
use App\Contact;
use App\Payment;
use App\Cart;
use App\Item;
use App\Admin;

class ContactController extends Controller
{
	public function index() {
		if (Auth::check()) {
			$payments = Payment::with('cart.item')->where('user_id', Auth::id())->get();
			$user = Auth::user();
			if ($payments->count() > 0) {
				return view('contact.index', compact('user', 'payments'));
			}
			return view('contact.index', compact('user'));
		}
		return view('contact.index');
	}

	public function confirm(ContactRequest $request) {
		if (!empty($request->payment_id)) {
			$payment = Payment::with('cart.item')->where('id', $request->payment_id)->where('user_id', Auth::id())->first();
			if (!empty($payment)) {
				$request->merge(['item_name' => $payment->cart->item->name]);
			} else {
				return redirect(route('item.index'))->with('flash_message', '不正アクセス');
			}
		} else {
			$request->merge(['item_name' => null]);
		}
		$inputs = $request->all();
		$request->session()->put($inputs);
		return view('contact.confirm', compact('inputs'));
	}

	public function send(Request $request) {
		if ($request->action == 'back') {
			$data = session()->all();
			return redirect('contact/index')->withInput($data);
		}
		$data = session()->all();
		$contact = new Contact;
		$contact->name = $data['name'];
		$contact->email = $data['email'];
		$contact->content = $data['content'];
		if (!empty($data['payment_id'])) {
			$contact->payment_id = $data['payment_id'];
		} else {
			$contact->payment_id = null;
		}
		if (Auth::check()) {
			$contact->user_id = Auth::id();
		} else {
			$contact->user_id = null;
		}
		$contact->save();
		$admins = Admin::all();
		\Notification::send($admins, new ContactNotification($data));
		$contact->contactNotification($data);
		return redirect(route('item.index'))->with('flash_message', '送信完了');

	}
}
