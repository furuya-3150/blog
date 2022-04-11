<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Refund;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Cart;
use App\Item;

class OrderController extends Controller
{
	public function index() {
		$purchase_historys = Payment::all();
		return view('admin/order/index', compact('purchase_historys'));
	}

	public function detail($id) {
		$payment = Payment::with('cart.item')->where('id', $id)->first();
		return view('admin/order/detail', compact('payment'));
	}

	public function refund($id) {
		$purchase_history = Payment::with('cart')->where('id', $id)->whereNull('refunded_at')->first();
		if (empty($purchase_history)) {
			return redirect(route('admin.order.index'))->with('flash_message', '不正アクセス');
		}
		Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
		Refund::create(array(
			'charge' => $purchase_history->payment_code,
			'amount' => $purchase_history->total
		));
		$purchase_history->refunded_at = Date("Y/m/d H:i:s");
		$purchase_history->save();
		$purchase_history->refundNotification($purchase_history->cart->total);
		return redirect(route('admin.order.index'))->with('flash_message', '返金しました');
	}

	public function inDelivary($id) {
		$purchase_history = Payment::with('cart.item')->where('id', $id)->whereNull('refunded_at')->whereNull('in_delivary')->first();
		if (empty($purchase_history)) {
			return redirect(route('admin.order.index'))->with('flash_message', '不正アクセス');
		}
		$purchase_history->in_delivary = Date("Y/m/d H:i:s");
		$purchase_history->save();
		$purchase_history->InDelivaryNotification($purchase_history->cart->item->name);
		return redirect(route('admin.order.index'))->with('flash_message', '商品を配送しました');
	}

	public function delivared($id) {
		$purchase_history = Payment::with('cart.item')->where('id', $id)->whereNull('refunded_at')->whereNull('delivared_at')->first();
		if (empty($purchase_history)) {
			return redirect(route('admin.order.index'))->with('flash_message', '不正アクセス');
		}
		$purchase_history->delivared_at = Date("Y/m/d H:i:s");
		$purchase_history->save();
		$purchase_history->delivaredNotification($purchase_history->cart->item->name);
		return redirect(route('admin.order.index'))->with('flash_message', '商品をお届けしました。');
	}

	public function search(Request $request) {
		session(['start_date' => $request->start_date]);
		session(['end_date' => $request->end_date]);
		session(['name' => $request->name]);
		$purchase_historys = $this->purchaseHistory();
		return view('admin/order/index', compact('purchase_historys'));
	}

	public function csvExport() {
		$headers = [
			'Content-type' => 'text/csv',
			'Content-Disposition' => 'attachment; filename=order_data_csvexport.csv',
			'Pragma' => 'no-cache',
			'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
			'Expires' => '0',
		];
		$callback = function() {
			$createCsvFile = fopen('php://output', 'w');
			$columns = [
				'name' , 'email', 'total', 'item_name', 'quantity', 'payment_code', 'postal_code', 'prefectures', 'municipalities', 'address'
			];
			mb_convert_variables('SJIS-win', 'UTF-8', $columns);
			fputcsv($createCsvFile, $columns);
			$purchase_historys = $this->purchaseHistory();
			if (empty($purchase_historys)) {
				$purchase_histrys = Payment::with('cart.item')->get();
			}
			foreach ($purchase_historys as $purchase_history) {
				$csv = [
					$purchase_history->name, $purchase_history->email, $purchase_history->total, $purchase_history->cart->item->name, $purchase_history->cart->quantity, $purchase_history->payment_code, $purchase_history->postal_code, $purchase_history->prefectures, $purchase_history->municipalities, $purchase_history->address
				];
				mb_convert_variables('SJIS-win', 'UTF-8', $csv);
				fputcsv($createCsvFile, $csv);
			}
			fclose($createCsvFile);
		};
		return response()->stream($callback, 200, $headers);
	}

	public function purchaseHistory() {
		$query = Payment::query()->with('cart.item');
		if (!empty(session('start_date'))) {
			$query->whereDate('created_at', '>=', session('start_date'))->get();
		}

		if (!empty(session('end_date'))) {
			$query->whereDate('created_at', '<=', session('end_date'))->get();
		}

		if (!empty(session('name'))) {
			$query->where('name', 'like', '%' . session('name') . '%')->get();
		}
		return $query->paginate(10);
	}


}
