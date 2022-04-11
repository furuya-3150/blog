<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Refund;
use App\Http\Requests\PaymentRequest;
use App\Payment;
use App\User;
use App\Cart;
use Exception;

class PaymentController extends Controller
{
	public function payment(PaymentRequest $request, $totals) {
		try {
			Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
			$customer = Customer::create(array(
				'email' => $request->stripeEmail,
				'source' => $request->stripeToken
			));
			$charge = Charge::create(array(
				'customer' => $customer->id,
				'amount' => $totals,
				'currency' => 'jpy'
			));
			$chargeId = $charge['id'];
			$separate_address = $this->separate_address($request->stripeShippingAddressLine1);
			if ($separate_address == false) {
				throw new Exception('不正な住所により決済失敗');
			}
			$carts = Cart::with('item')->where('user_id', Auth::id())->whereNull('bought_at')->get();
			$postal_code = str_replace("-", "", $request->stripeBillingAddressZip);
			$postal_code = substr($postal_code, 0, 3) . "-" . substr($postal_code, 3);
			DB::beginTransaction();
			foreach ($carts as $cart) {
				$param = [
					'name' => $request->stripeBillingName,
					'email' => $request->stripeEmail,
					'total' => $cart->item->value * $cart->quantity,
					'payment_code' => $chargeId,
					'postal_code' => $postal_code,
					'prefectures' => $separate_address['state'],
					'municipalities' => $separate_address['city'],
					'address' => $separate_address['other'],
					'user_id' => Auth::id(),
					'cart_id' => $cart->id
				];
				Payment::create($param);
				$cart->bought_at = Date("Y/m/d H:i:s");
				$cart->save();
			}
			$user = User::where('id', Auth::id())->first();
			$user->stripe_id = $customer->id;
			$user->save();
			DB::commit();
			return redirect(route('cart.index'))->with('flash_message', '決済完了');
		} catch(Exception $e) {
			if ($chargeId !== null) {
				Refund::create(array(
					'charge' => $chargeId,
				));
			}
			DB::rollback();
			return redirect(route('cart.index'))->with('flash_message', '決済に失敗しました');
		}
	}
	private function separate_address($address) {
		if (preg_match('@^(.{2,3}?[都道府県])(.+?郡.+?[町村]|.+?市.+?区|.+?[市区町村])(.+)@u', $address, $matches) === 1) {
			return [
				'state' => $matches[1],
				'city' => $matches[2],
				'other' => $matches[3],
			];
		}
		return false;
	}
}
