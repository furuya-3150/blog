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
<title>お届け先登録</title>
</head>
<body>
<div align="center">
<h2>お届け先登録</h2>
<form method="post" action="{{ route('addressee.create') }}">
{{ csrf_field() }}
<p>名前:<input type="text" name="name" value="{{ old('name') }}"></p>
<p>郵便番号:<input type="text" name="postal_code" value="{{ old('postal_code') }}"></p>
<p>都道府県名:<input type="text" name="prefectures" value="{{ old('prefectures') }}"></p>
<p>市区町村名:<input type="text" name="municipalities" value="{{ old('municipalities') }}"></p>
<p>それ以下の住所:<input type="text" name="address" value="{{ old('address') }}"></p>
<p>電話番号:<input type="text" name="telephone_number" value="{{ old('telephone_number') }}"></p>
<p><input type="submit" value="登録"></p>
</form>
<div>
</body>
</html>
@endsection

