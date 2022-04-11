<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddresseeRequest;
use Illuminate\Support\Facades\DB;
use App\Addressee;

class AddresseeController extends Controller
{
	public function registeredAddressee() {
		$registered_addressee = Addressee::where('user_id', Auth::id())->whereNotNull('select')->first();
		return $registered_addressee;
	}
	public function index() {
		$addressees = Addressee::where('user_id', Auth::id())->get();
		$registered_addressee = $this->registeredAddressee();
		return view('addressee/index', ['addressees' => $addressees, 'registered_addressee' => $registered_addressee]);
	}

	public function select() {
		$addressees = Addressee::where('user_id', Auth::id())->get();
		$registered_addressee = $this->registeredAddressee();
		return view('addressee/select', ['addressees' => $addressees, 'registered_addressee' => $registered_addressee]);

	}

	public function registerAddressee(Request $request) {
		$addressee = Addressee::where('id', $request->addressee_id)->first();
		if (isset($addressee)) {
			if ($addressee->user_id === Auth::id()) {
				$addressee_select = Addressee::where('id', Auth::id())->whereNotNull('select')->first();
				if (isset($addressee_select)) {
					$addressee_select->select = null;
					$addressee_select->save();
				}
				$addressee->select = date("Y-m-d H:i:s");
				$addressee->save();
				return redirect(route('addressee.index'))->with('flash_message', '登録しました');
			} else {
				return redirect(route('addressee.index'))->with('flash_message', '不正アクセス');
			}
		} else {
			return redirect(route('addressee.index'))->with('flash_message', '不正アクセス');
		}
	}

	private function md5Addressee($request) {
		$sum_md5 = md5($request->postal_code . $request->prefectures . $request->municipalities . $request->address . Auth::id());
		return $sum_md5;
	}

	private function hasSameData($request) {
		$addressee = Addressee::where('sum_md5', $request->sum_md5)->first();
		if (isset($addressee)) {
			return $addressee->id;
		}
		return null;
	}

	public function create(AddresseeRequest $request) {
		$addressee = new Addressee;
		$registerer_addressee = Addressee::where('user_id', Auth::id())->get();
		return $registered_addressee;
		$sum_md5 = $this->md5Addressee($request);
		if (empty($registered_address)) {
			$request->merge(['select' => date("Y-m-d H:i:s")]);
		}
		$request->merge(['user_id' => Auth::id()]);
		$request->merge(['sum_md5' => $sum_md5]);
		$residence_id = $this->hasSameData($request);
		if (isset($residence_id)) {
			return redirect(route('addressee.index'))->with('flash_message', '既に登録済みのお届け先です');
		}
		$addressee->fill($request->all())->save();
		return redirect(route('addressee.index'))->with('flash_message', 'お届け先を登録');

	}

	public function edit($addressee_id) {
		$addressee = Addressee::where('id', $addressee_id)->first();
		if (isset($addressee)) {
			if ($addressee->user_id === Auth::id()) {
				return view('addressee.edit', ['addressee' => $addressee]);
			}
		}
		return redirect(route('addressee.index'))->with('flash_message', '不正アクセス');
	}

	public function update(AddresseeRequest $request, $addressee_id) {
		$addressee = (new Addressee)->find($addressee_id);
		if (isset($addressee)) {
			if ($addressee->user_id === Auth::id()) {
				$sum_md5 = $this->md5Addressee($request);
				$request->merge(['sum_md5' => $sum_md5]);
				$residence_id = $this->hasSameData($request);
				if (isset($residence_id) && (string) $residence_id !== $addressee_id) {
					return redirect(route('addressee.index'))->with('flash_message', '既に登録済みのお届け先ですね');
				}
				$addressee->fill($request->all())->save();
				return redirect(route('addressee.index'))->with('flash_message', '編集しました');
			} else{
				return redirect(route('addressee.index'))->with('flash_message', '不正アクセス');
			}
		} else {
			return redirect(route('addressee.index'))->with('flash_message', '不正アクセス');
		}
	}

	public function delete($addressee_id) {
		$addressee = Addressee::where('id', $addressee_id)->first();
		if (isset($addressee)) {
			if ($addressee->user_id === Auth::id()) {
				$addressee->delete();
				return redirect(route('addressee.index'))->with('flash_message', '削除しました');
			}
		}
		return redirect(route('addressee.index'))->with('flash_message', '不正アクセス');
	}
}
