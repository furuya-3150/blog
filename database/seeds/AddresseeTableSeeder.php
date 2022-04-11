<?php

use Illuminate\Database\Seeder;
use App\Addressee;

class AddresseeTableSeeder extends Seeder
{
    public function run()
	{
		$name = 'nekootoko';
		$postal_code = '100-1234';
		$prefectures = '千葉県';
		$municipalities = '船橋市';
		$address = '1234';
		$telephone_number = '090-1234-1234';
		$user_id = 3;
		$sum_md5 = md5($postal_code . $prefectures . $municipalities . $address . $user_id);
		Addressee::create(compact('name', 'postal_code', 'prefectures', 'municipalities', 'address', 'telephone_number', 'user_id', 'sum_md5'));
    }
}
