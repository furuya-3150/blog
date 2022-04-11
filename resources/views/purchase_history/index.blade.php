@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>注文履歴</title>
</head>
<body>
<h1>注文履歴</h1>
<table border="1">
<tr>
<th>注文日時</th>
<th>合計金額</th>
<th>お届け先</th>
<th>商品情報</th>
</tr>
@foreach ($purchase_historys as $purchase_history)
<tr>
<td>{{ $purchase_history->created_at }}</td>
<td>{{ $purchase_history->total }}円</td>
<td>〒{{ $purchase_history->postal_code}}
</br>{{ $purchase_history->prefectures . $purchase_history->municipalities . $purchase_history->address}}</td>
<td>{{ $purchase_history->cart->item->name }}を</br>
{{ $purchase_history->cart->quantity }}個購入</td>
@if (is_null($purchase_history->in_delivary))
<td><a href="{{ route('purcahse_history.refund', $purchase_history->id) }}">注文キャンセル</a></td>
@endif
</tr>
@endforeach
</table>
<a href="{{ route('item.index') }}">商品一覧</a>
</body>
</html>
