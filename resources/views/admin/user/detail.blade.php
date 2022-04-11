@extends('layouts.app')
@section('content')
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>会員一覧</title>
</head>
<body>
<div align="center">
<h1>会員一覧ページ</h1>
<table border="1">
<tr>
<th>名前</th>
<th>メールアドレス</th>
<th>住所</th>
</tr>
<tr>
<td>{{ $user->name}}</td>
<td>{{ $user->email}}</td>
@if (isset($addressee))
<td>〒{{ $addressee->postal_code}}
</br>{{ $addressee->prefectures . $addressee->municipalities . $addressee->address }}</td>
@else
<td>住所が登録されていません</td>
@endif
</tr>
</table>
<div>
</body>
</html>
@endsection
