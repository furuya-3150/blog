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
<title>アカウント編集</title>
</head>
<body>
<div align="center">
<h1>アカウント編集</h1>
<form method="post" action="{{ route('user.update') }}">
{{ csrf_field() }}
<p>名前</p>
<input type="text" name="name" value="{{ old('name', $user['name']) }}">
<p>メールアドレス</p>
<input type="text" name="email" value="{{ old('mail', $user['email']) }}">
<p>パスワード</p>
<input type="text" name="password">
<p>パスワード(確認用)</p>
<input type="text" name="password_confirmation">
<p>現在のパスワード</p>
<input type="text" name="now_password" value="{{ old('now_password') }}">
<p><input type="submit" value="編集"></p>
<div>
</body>
</html>
@endsection
