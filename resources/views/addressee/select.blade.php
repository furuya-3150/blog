@extends('layouts.app')
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>住所選択</title>
</head>
<body>
<div align="center">
@if (Auth::check() && isset($registered_addressee))
<p>お届け先:{{ $registered_addressee->name }}さん</p>
<p>〒{{ $registered_addressee->postal_code}}</p>
@endif
<h2>お届け先選択</h2>
@if (0 < $addressees->count())
<table border=1>
<tr>
<th></th>
<th>名前</th>
<th>お届け先住所</th>
<th>電話番号</th>
</tr>
@foreach ($addressees as $addressee)
<form method="post" action="{{ route('addressee.register') }}">
{{ csrf_field() }}
<tr>
<td><input type="radio" name="addressee_id" value="{{ $addressee->id }}"</td>
<td>{{ $addressee->name }}</td>
<td>〒{{ $addressee->postal_code }}
</br>{{ $addressee->prefectures . $addressee->municipalities . $addressee->address }}</td>
<td>{{ $addressee->telephone_number }}</td>
<td><a href="{{ route('addressee.edit', $addressee->id) }}">編集</td>
<td><a href="{{ route('addressee.delete', $addressee->id) }}">削除</a></td>
</tr>
@endforeach
</table>
<p>
<input type="submit" name="submit" value="お届け先登録">
</form>
</p>
@else
<p>お届け先は登録されていません</p>
@endif
<p><a href="{{ route('addressee.view.create') }}">お届け先住所追加</a></p>
</body>
<div>
</html>
