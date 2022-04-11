<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;

class DataController extends Controller
{
	public function index() {
		return view('admin/data/index');
	}

	public function importCsv(Request $request) {
		 $request->validate([
			 'csvfile' => 'required|file|mimes:csv,txt|mimetypes:text/plain'
		 ]);
		 $file_path = $request->file('csvfile')->path();
		 $csvFile = new \SplFileObject($file_path);
		 $csvFile->setFlags(
			 \SplFileObject::READ_CSV |
			 \SplFileObject::READ_AHEAD|
			 \SplFileObject::SKIP_EMPTY|
			 \SplFileObject::DROP_NEW_LINE
		 );
		 $row_count = 1;
		 try {
			 foreach ($csvFile as $line) {
				 if ($row_count > 1) {
					 $id = $line[0];
					 $name = $line[1];
					 $description = $line[2];
					 $value = $line[3];
					 $stock = $line[4];
					 if (256 < mb_strlen($name)) {
						 $errors = "・商品名は256文字以内で入力してください\n";
					 }
					 if (256 < mb_strlen($description)) {
						 if (!empty($erorrs)) {
							 $errors .= '・商品説明は256文字以内で入力してください<br>';
						 } else {
							 $errors = "・商品説明は256文字以内で入力してください\n";
						 }
					 }
					 if (ctype_digit($value) === false) {
						 if (!empty($erorrs)) {
							 $errors .= "・商品の価格は正の整数のみにしてください\n";
						 } else {
							 $errors .= "・商品の価格は正の整数のみにしてください\n";
						 }
					 }
					 if (ctype_digit($stock) === false) {
						 if (!empty($erorrs)) {
							 $errors .= "・商品の在庫は正の整数のみにしてください";
						 } else {
							 $errors = "・商品の在庫は正の整数のみにしてください";
						 }
					 }
					 if (!empty($errors)) {
						 return redirect(route('admin.data.index'))->with('flash_message', $errors);
					 }
					 $item = Item::where('id', $id)->first();
					 if (!empty($item)) {
						 $item->name = $name;
						 $item->description = $description;
						 $item->value = $value;
						 $item->stock = $stock;
						 $item->save();
					 } else {
						 Item::insert([
							 'name' => $name,
							 'description' => $description,
							 'value' => $value,
							 'stock' => $stock
						 ]);
					 }
				 }
				 $row_count++;
			 }
		 } catch(\Exception $e) {
			 echo $e->getMessage();
			 exit;
		 }
		 return redirect(route('admin.index'))->with('flash_message', 'データをインポートしました');
	}
}
