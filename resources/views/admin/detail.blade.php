@extends('layouts.app')
@section('content')
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>商品詳細</title>
</head>
<body>
<div align="center">
<h1>商品詳細</h1>
<table border="1">
<tr>
<th>商品名</th>
<th>商品画像</th>
<th>商品説明</th>
<th>値段</th>
<th>在庫の有無</th>
</tr>
<tr>
<td>{{ $item->name }}</td>
@if (!empty($item->image))
<td><img src="{{ asset($item->image) }}" width="100px" height="100px"></td>
@else
<td>画像なし</td>
@endif
<td>{{ $item->description }}</td>
<td>{{ $item->value }}円</td>
@if ($item->stock)
<td>在庫あり</td>
@else
<td>在庫無し</td>
@endif
</tr>
</table>
<a href="{{ route('admin.edit', $item->id) }}">編集</a>
</div>
</body>
</html>
@endsection
