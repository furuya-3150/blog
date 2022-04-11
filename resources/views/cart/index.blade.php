@extends('layouts.app')
@section('content')
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
@if ($errors->any())
	<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	</div>
@endif
<!DOCTYPE html>
<html lang="ja">
<head>
<title>カート</title>
<meta charset="utf-8">
</head>
@if (0 < $carts->count())
<body>
<h1 align="center">カート</h1>
<table border="1" align="center" width="60%">
<tr>
<th>商品名</th>
<th>価格(円)</th>
<th>購入数</th>
<th>小計(円)</th>
</tr>
@foreach ($carts as $cart)
<tr>
<td>{{ $cart->item->name }}</td>
<td>{{ $cart->item->value }}</td>
<td>{{ $cart->quantity }}</td>
<td>{{ $cart->item->value * $cart->quantity}}</td>
<td><a href="{{ route('cart.delete', $cart->id) }}">削除</a></td>
</tr>
@endforeach
@else
<p>カートが空です</p>
@endif
</table>
<p align="center">合計:{{ $totals }}円</p>
@if ($totals > 0)
<form action="{{ route('payment', $totals) }}" method="post"  align="center">
{{ csrf_field() }}
<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
	data-key="{{ env('STRIPE_KEY') }}"
	data-amount="{{ $totals }}"
	data-name="Stripe Demo"
	data-label="決済をする"
	data-description="これはStripeのデモです"
	data-zipCode="ture"
	data-shippingAddress="true"
	data-locale="auto"
	data-currency="jpy"
</script>
</form>
@endif
</body>
</html>
@endsection
