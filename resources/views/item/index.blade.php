@extends('layouts.app')
@section('content')
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<html>
<head>
<meta charset="utf-8">
<title>商品一覧</title>
<link rel="stylesheet" href="{{ asset('/css/star_styles.css') }}">
<head>
<body>
<h1 style="text-align:center">商品一覧</h1>
<table align="center" border="1" width="60%">
<tr>
<th>商品名</th>
<th>評価</th>
<th>商品画像</th>
<th>値段</th>
<th>在庫</th>
</tr>
@foreach ($items as $item)
<tr>
<td><a href="{{ route('detail.show', $item->id) }}">{{ $item->name }}</a></td>
@if (!empty($ratings[$item->id]))
<td><span class="star5_rating" data-rate="{{ $ratings[$item->id] }}"></span></td>
@else
<td></td>
@endif
@if (!empty($item->image))
<td><img src="{{ asset($item->image) }}" width="100px" height="100px"></td>
@else
<td></td>
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
</body>
</html>
@endsection
