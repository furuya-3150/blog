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
<title>コメント追記</title>
</head>
<body>
<div align="center">
<h4>コメント追記</h4>
<form method="post" action="{{ route('review.editRecieve') }}">
{{ csrf_field() }}
<textarea name="comment" rows="4" cols="40">{{ $review->comment }}</textarea>
<br>
<input type="submit" value="追記">
</form>
</div>
</body>
</html>
@endsection
