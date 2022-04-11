@extends('layouts.app')
@section('content')
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>お届け先</title>
</head>
<body>
<div align="center">
@if (Auth::check() && isset($registered_addressee))
<p>お届け先:{{ $registered_addressee->name }}さん</p>
<p>〒{{ $registered_addressee->postal_code}}</p>
@endif
<h1>お届け先</h1>
@if (0 < $addressees->count())
<table border=1>
<tr>
<th>名前</th>
<th>お届け先住所</th>
<th>電話番号</th>
</tr>
@foreach ($addressees as $addressee)
<tr>
<td>{{ $addressee->name }}</td>
<td>〒{{ $addressee->postal_code}}
</br>{{ $addressee->prefectures . $addressee->municipalities . $addressee->address}}</td>
<td>{{ $addressee->telephone_number}}</td>
<td><a href="{{ route('addressee.edit', $addressee->id) }}">編集</td>
<td><a href="{{ route('addressee.delete', $addressee->id) }}">削除</a></td>
</tr>
@endforeach
</table>
<p><a href="{{ route('addressee.select') }}">お届け先選択</a></p>
@else
<p>お届け先は登録されていません</p>
@endif
<p><a href="{{ route('addressee.view.create') }}">お届け先住所追加</a></p>
</div>
</body>
</html>
@endsection
