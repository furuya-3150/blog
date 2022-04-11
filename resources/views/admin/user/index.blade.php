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
<h3>会員一覧ページ</h3>
<table>
<tr>
<th>id</th>
<th>name</th>
</tr>
@foreach ($users as $user)
<tr>
<td>{{ $user->id }}</td>
<td><a href="{{ route('admin.user.detail', $user->id) }}">{{ $user->name}}</a></td>
</tr>
@endforeach
</table>
</div>
</body>
</html>
@endsection
