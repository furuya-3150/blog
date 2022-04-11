<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Item;

class CartController extends Controller
{
	public function index() {
		$carts = Cart::with('item')->where('user_id', Auth::id())->whereNull('bought_at')->get();
		$totals = $this->totals($carts);
		return view('cart.index', compact('carts', 'totals'));
	}

	private function totals($carts) {
		$result = 0;
		foreach ($carts as $cart) {
			$result += $cart->item->value * $cart->quantity;
		}
		return $result;
	}

	public function delete($cart_id) {
		$cart = Cart::where('id', $cart_id)->first();
		if (isset($cart) && $cart->user_id == Auth::id()) {
			DB::beginTransaction();
			try{
				$item_id = $cart->item_id;
				$qty = $cart->quantity;
				$cart->delete();
				$item = Item::find($item_id);
				$item->increment('stock', $qty);
				DB::commit();
				return redirect(route('cart.index'))->with('flash_message', '削除しました');
			} catch (Exception $e) {
				DB::rollback();
				return redirect(route('cart.index'))->with('flash_message', 'データーベースエラー');
			}
		} else {
			return redirect(route('item.index'))->with('flash_message', '不正なアクセスです');
		}
	}

	public function add($item_id) {
		$item = Item::where('id', $item_id)->first();
		if (isset($item)) {
			$cart = Cart::where('item_id', $item_id)->where('user_id', Auth::id())->whereNull('bought_at')->first();
			$quantity = $item->stock;
			if ($quantity <= 0) {
				return redirect(route('item.index'))->with('flash_message', '在庫なし');
			}
		} else {
			return redirect(route('item.index'))->with('flash_message', '不正アクセス');
		}
		DB::beginTransaction();
		try {
			if (isset($cart)) {
				$cart->increment('quantity');
			} else {
				Cart::create(['user_id' => Auth::id(), 'item_id' => $item_id, 'quantity' => 1]);
			}
			$item->decrement('stock');
			DB::commit();
			return redirect(route('cart.index'))->with('flash_message', 'カートに追加しました');
		} catch (Exception $e) {
			DB::rollback();
			return redirect(route('cart.index'))->with('flash_message', 'データーベースエラー');
		}
	}
}
