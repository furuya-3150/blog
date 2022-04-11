<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReviewRequest;
use App\Item;
use App\Review;

class ItemController extends Controller {
	public function index() {
		$items = Item::all();
		$ratings = $this->avgRatings();
		return view('item/index', compact('items', 'ratings'));
	}
	public function show($id) {
		$item = Item::where('id', $id)->first();
		if (empty($item)) {
			return redirect('../public');
		}
		$review = Review::where('user_id', Auth::id())->where('item_id', $id);
		if ($review->count() > 0) {
			$hidden = true;
		} else {
			$hidden = null;
		}
		$rating = $this->avgRating($id);
		$reviews = Review::where('item_id', $id)->get();
		return view('item/detail', compact('item', 'hidden', 'rating', 'reviews'));
	}

	public function reviewCreate($item_id) {
		session()->forget('item_id');
		session(['item_id' => $item_id]);
		return view('item/review/create', compact('item_id'));
	}

	public function reviewCreateRecieve(ReviewRequest $request) {
		$item = Item::where('id', session('item_id'))->first();
		if (!empty($item)) {
			$review = new Review;
			$review->item_id = session('item_id');
			$review->user_id = Auth::id();
			$review->stars = $request->rate;
			if (!empty($request->comment)) {
				$review->comment = $request->comment;
			}
			$review->save();
			return redirect(route('item.index'))->with('flash_message', 'レビューしました');
		}
		return redirect(route('item.index'))->with('flash_message', '不正アクセス');
	}

	public function reviewEdit($id) {
		$review = Review::where('id', $id)->where('user_id', Auth::id())->first();
		session()->forget('review_id');
		session(['review_id' => $id]);
		if (!empty($review)) {
			return view('item/review/edit', compact('review'));
		}
		return redirect(route('item.index'))->with('flash_message', '不正アクセス');
	}

	public function reviewEditRecieve(Request $request) {
		$validatedData = $request->validate([
			'comment' => 'nullable|max:256'
		]);
		$review = Review::where('id', session('review_id'))->where('user_id', Auth::id())->first();
		if (!empty($review)) {
			$review->comment = $request->comment;
			$review->save();
			return redirect(route('item.index'))->with('flash_message', '追記完了');
		}
		return redirect(route('item.index'))->with('flash_message', '不正アクセス');

	}

	private function avgRatings() {
		$rates = DB::table('reviews')
			->select('item_id', DB::raw('avg(stars) as avg_rating'))
			->groupBy('item_id')
			->get();
		foreach ($rates as $rate) {
			$ratings[$rate->item_id] = round($rate->avg_rating, 1);
		}
		return $ratings;
	}

	private function avgRating($id) {
		$rate = DB::table('reviews')
			->where('item_id', $id)
			->select(DB::raw('avg(stars) as avg_rating'))
			->first();
		$rate = round($rate->avg_rating, 1);
		return $rate;
	}

}
