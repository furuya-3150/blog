@extends('layouts.app')
@section('content')
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<html>
<body>
<div align="center">
<h1>商品一覧</h1>
<a href="{{ route('admin.create') }}">商品追加</a>
<table align="center" border="1" width="60%">
<tr>
<th>商品名</th>
<th>商品画像</th>
<th>値段</th>
<th>在庫</th>
</tr>
@foreach ($items as $item)
<tr>
<td><a href="{{ route('admin.detail', $item->id) }}">{{ $item->name }}</a></td>
@if (!empty($item->image))
<td><img src="{{ asset($item->image) }}" width="100px" height="100px"></td>
@else
<td>画像なし</td>
@endif
<td>{{ $item->value }}円</td>
@if ($item->stock)
<td>在庫あり</td>
@else
<td>在庫無し</td>
@endif
</tr>
@endforeach
</table>
<a href="{{ route('admin.item.export_csv') }}">csvファイルダウンロード</a>
</div>
</body>
</html>
@endsection
