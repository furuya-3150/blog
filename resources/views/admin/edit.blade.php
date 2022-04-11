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
<title>編集</title>
<meta charset="utf-8">
</head>
<body>
<div align="center">
<h3>編集</h3>
<form method="post" action="{{ route('admin.update', $item->id) }}" enctype="multipart/form-data">
{{ csrf_field() }}
<div>商品名:<input type="text" name="name" value="{{ old('name', $item->name) }}"></div>
<div>商品画像:<input type="file" name="image"></div>
<div>説明:<textarea name="description">{{ old('description', $item->description) }}</textarea></div>
<div>在庫:<input type="text" name="stock" value="{{ old('stock', $item->stock) }}"><div>
<div><button type="submit">登録</button><div>
</form>
</div>
</body>
<html>
@endsection
