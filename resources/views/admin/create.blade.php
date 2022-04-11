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
<title>新規登録</title>
<meta charset="utf-8">
</head>
<body>
<div align="center">
<h1>新規登録</h1>
<form method="post" action="{{ route('admin.create') }}" enctype="multipart/form-data">
{{ csrf_field() }}
<div>商品名:<input type="text" name="name" value="{{ old('name') }}"></div>
<div>商品画像:<input type="file" name="image" value="{{ old('image') }}"></div>
<div>説明:<textarea name="description">{{ old('description') }}</textarea></div>
<div>値段:<input type="text" name="value" value="{{ old('value') }}">円</div>
<div>在庫:<input type="text" name="stock" value="{{ old('stock') }}"><div>
<div><button type="submit">登録</button><div>
<p><a href="{{ route('admin.data.index') }}">csvファイルで登録する</a></p>
</form>
</div>
</body>
<html>
@endsection
