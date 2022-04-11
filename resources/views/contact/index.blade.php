@extends('layouts.app')
@section('content')
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
<meta charset="utf-8">
<title>お問合せフォーム</title>
</head>
<body>
<div align="center">
<h2>お問合せ</h2>
<form action="{{ route('contact.confirm') }}" method="post">
{{ csrf_field() }}
@if (!empty($user))
<p>お名前</p>
<input name="name" type="text" value="{{ old('name', $user->name) }}">
<p>メールアドレス</p>
<input name="email" type="text" value="{{ old('email', $user->email) }}">
@else
<p>お名前</p>
<input name="name" type="text" value="{{ old('name') }}">
<p>メールアドレス</p>
<input name="email" type="text" value="{{ old('email') }}">
@endif
@if (!empty($payments))
<div>
<label>件名</label>
<select name="payment_id">
<option  value=>選択してください</option>
@foreach ($payments as $payment)
<option value="{{ $payment->id }}">{{ $payment->cart->item->name }}について</option>
@endforeach
</select>
</div>
@endif
<p>内容</p>
<textarea name="content">{{ old('content') }}</textarea>
</br>
<button type="submit">入力内容確認</button>
</form>
</div>
</body>
</html>
@endsection
