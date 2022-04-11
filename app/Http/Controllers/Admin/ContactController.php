<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Payment;

class ContactController extends Controller
{
	public function index() {
		$contacts = Contact::all();
		return view('admin.contact.index', compact('contacts'));
	}

	public function detail($id) {
		$contact = Contact::where('id', $id)->first();
		if (!empty($contact)) {
			if (!empty($contact->payment_id)) {
				$contact = Contact::with('payment.cart.item')->where('id', $id)->first();
			}
			return view('admin.contact.detail', compact('contact'));
		}
		return redirect(route('admin.contact.index'))->with('flash_message', '不正アクセス');

	}
}
