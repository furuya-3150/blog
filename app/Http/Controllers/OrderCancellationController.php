<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Refund;
use App\Payment;
use App\Cart;
use App\Item;

class OrderCancellationController extends Controller
{
	public function index() {
		$purchase_historys = Payment::with('cart.item')->where('user_id', Auth::id())->whereNull('in_delivary')->whereNull('refunded_at')->get();
		return view('purchase_history/index', compact('purchase_historys'));
	}

	public function refund($id) {
		$purchase_history = Payment::where('id', $id)->where('user_id', Auth::id())->whereNull('in_delivary')->whereNull('refunded_at')->first();
		if (empty($purchase_history)) {
			return redirect(route('purcahse_history.index'))->with('flash_message', '不正アクセス');
		}
		Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
		Refund::create(array(
			'charge' => $purchase_history->payment_code,
			'amount' => $purchase_history->total
		));
		$purchase_history->refunded_at = Date("Y/m/d H:i:s");
		$purchase_history->save();
		return redirect(route('purcahse_history.index'))->with('flash_message', '注文をキャンセルしました。');
	}
}
