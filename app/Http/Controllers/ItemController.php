<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller {
	public function index() {
		$items = Item::all();
		return view('item/index', ['items' => $items]);
	}
	public function show($id) {
		$item = Item::where('id', $id)->first();
		if (empty($item)) {
			return redirect('../public');
		}
		return view('item/detail', ['item' => $item]);
	}

}
