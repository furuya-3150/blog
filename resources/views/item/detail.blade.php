@extends('layouts.app')
@section('content')
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="{{ asset('/css/star_styles.css') }}">
<title>商品詳細</title>
</head>
<body>
<h3 style="text-align:center">商品詳細</h3>
<table align="center" border="1" width="60%">
<tr>
<th>商品名</th>
<th>評価</th>
<th>商品画像</th>
<th>商品説明</th>
<th>値段</th>
<th>在庫の有無</th>
</tr>
<tr>
<td>{{ $item->name }}</td>
@if (!empty($rating))
<td><span class="star5_rating" data-rate="{{ $rating }}"></span></td>
@else
<td></td>
@endif
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
<td>
@if ($hidden === true)
<p align="center">※既にレビュー済みです</p>
@else
<p align="center"><a href="{{ route('review.create', $item->id) }}">レビュー</a></p>
@endif
</td>
</tr>
</table>
@if (empty($item->stock))
<p align="center">※在庫なし</p>
@else
<form align="center" action="{{ route('cart.add', $item->id) }}" method="post">
{{ csrf_field() }}
<input type="submit" name="submit" value="カートに追加">
</form>
@endif
<div align="center">
<h4>レビュー覧</h4>
@if (($reviews->count() > 0))
@foreach ($reviews as $review)
<span class="star5_rating" data-rate="{{ $review->stars }}"></span>
<p>
{{ $review->comment }}
@if ($review->user_id == Auth::id())
<a href="{{ route('review.edit', $review->id) }}">追記する</a>
</p>
@endif
<br>
@endforeach
@else
<p>※レビューはありません</p>
@endif
</div>
</body>
</html>
@endsection
