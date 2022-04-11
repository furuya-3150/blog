@extends('layouts.app')
@section('content')
<html>
<body>
<div align="center">
<h1>注文詳細</h1>
<table border="1">
<tr>
<th>注文日</th>
<th>合計金額</th>
<th>お届け先氏名</th>
<th>お届け先住所</th>
<th>商品情報</th>
<th>商品ステータス</th>
</tr>
<tr>
<td>{{ $payment->created_at }}</td>
<td>{{ $payment->total}}円</td>
<td>{{ $payment->name}}</td>
<td>〒{{ $payment->postal_code}}
</br>{{ $payment->prefectures . $payment->municipalities . $payment->address}}</td>
<td>{{ $payment->cart->item->name }}を
{{ $payment->cart->quantity }}個購入</td>
@if (!empty($payment->refunded_at))
<td>返金済み</td>
@elseif (is_null($payment->in_delivary))
<td>未配達</td>
<td><a href="{{ route('admin.order.in_delivary', $payment->id) }}">配達する</a>
<a href="{{ route('admin.order.refund', $payment->id) }}">返金する</a></td>
@elseif (!empty($payment->in_delivary) && is_null($payment->delivared_at))
<td>配達中</td>
<td><a href="{{ route('admin.order.delivared', $payment->id) }} }}">配達済みにする</a>
<a href="{{ route('admin.order.refund', $payment->id) }}">返金する</a></td>
@elseif (!empty($payment->delivared_at))
<td>配達済み</td>
<td><a href="{{ route('admin.order.refund', $payment->id) }}">返金する</a></td>
@endif
</tr>
</table>
</div>
</body>
</html>
@endsection
