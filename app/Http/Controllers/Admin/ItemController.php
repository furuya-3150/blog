<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ItemRequest;
use App\Http\Controllers\Controller;
use App\Item;

class ItemController extends Controller
{
	public function index()
	{
		$items = Item::all();
		return view('admin.index', ['items' => $items]);
	}

	public function detail($id)
	{
		$item = Item::where('id', $id)->first();
		if (empty($item)) {
			return redirect('../public/admin/index');
		}
		return view('admin.detail', ['item' => $item]);
	}

	public function create()
	{
		return view('admin.create');
	}

	public function createReceive(ItemRequest $request)
	{
		$image = $request->image;
		if (!empty($image)) {
			$image_path = 'storage/uploads/' . $image->store('public/uploads');
		} else {
			$image_path = '';
		}
		$item = new Item;
		$item->name = $request->name;
		$item->image = $image_path;
		$item->description = $request->description;
		$item->value = $request->value;
		$item->stock = $request->stock;
		$item->save();
		return redirect(route('admin.index'));
	}

	public function edit($id)
	{
		$item = Item::where('id', $id)->first();
		if (empty($item)) {
			return redirect(route('admin.index'));
		}
		return view('admin.edit', ['item' => $item]);
	}

	public function update(ItemRequest $request, $id) {
		$item = Item::find($id);
		$image = $request->image;
		if (!empty($image)) {
			if (!empty($item->image)) {
				$img = Storage::delete('public/uploads/' . basename($item->image));
			}
			$image_path = $image->store('public/uploads');
			$item->image = 'storage/uploads/' . basename($image_path);
		}
		$item->name = $request->name;
		$item->description = $request->description;
		$item->stock = $request->stock;
		$item->save();
		return redirect(route('admin.detail', $id));
	}

	public function csvExport() {
		$headers = [
			'Content-type' => 'text/csv',
			'Content-Disposition' => 'attachment; filename=item_data_csvexport.csv',
			'Pragma' => 'no-cache',
			'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
			'Expires' => '0',
		];
		$callback = function() {
			$createCsvFile = fopen('php://output', 'w');
			$columns = [
				'id', 'name' , 'description', 'value', 'stock'
			];
			mb_convert_variables('SJIS-win', 'UTF-8', $columns);
			fputcsv($createCsvFile, $columns);
			$items = Item::all();
			foreach ($items as $item) {
				$csv = [
					$item->id, $item->name, $item->description, $item->value, $item->stock
				];
			mb_convert_variables('SJIS-win', 'UTF-8', $csv);
			fputcsv($createCsvFile, $csv);
			}
			fclose($createCsvFile);
		};
		return response()->stream($callback, 200, $headers);
	}
}
