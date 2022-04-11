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
<meta charset="utf-8">
<link rel="stylesheet" href="{{ asset('/css/rating_styles.css') }}">
<title>レビュー</title>
</head>
<body>
<div class="rating">
<h4>レビュー</h4>
<form method="post" action="{{ route('review.createRecieve') }}">
{{ csrf_field() }}
<div class="rate-form">
	<input id="star5" type="radio" name="rate" value="5">
	<label for="star5">★</label>
	<input id="star4" type="radio" name="rate" value="4">
	<label for="star4">★</label>
	<input id="star3" type="radio" name="rate" value="3">
	<label for="star3">★</label>
	<input id="star2" type="radio" name="rate" value="2">
	<label for="star2">★</label>
	<input id="star1" type="radio" name="rate" value="1">
	<label for="star1">★</label>
</div>
<h5>コメント</h5>
<textarea name="comment" cols="40" rows="4"></textarea>
</br>
<input type="submit" value="レビュー">
</form>
</div>
</body>
</html>
@endsection
