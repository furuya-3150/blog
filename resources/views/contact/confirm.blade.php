@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>お問合せフォーム</title>
</head>
<body>
<div align="center">
<h2>お問合せ内容確認</h2>
<form method="post" action="{{ route('contact.send') }}">
{{ csrf_field() }}
<div>
<label>お名前</label>
<span>{{ $inputs['name']}}</span>
</div>
<div>
<label>メールアドレス</label>
<span>{{ $inputs['email'] }}</span>
</div>
@if (!empty($inputs['item_name']))
<div>
<label>件名</label>
<span>{{ $inputs['item_name']}}について</span>
</div>
@endif
<div>
<label>お問合せ内容</label>
<span>{{ $inputs['content'] }}</span>
</div>
<button type="submit" name="action" value="back">戻る</button>
<button type="submit" name="action" value="register">送信する</button>
</form>
</div>
</body>
</html>
@endsection
