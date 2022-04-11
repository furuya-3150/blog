@extends('layouts.app')
@section('content')
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<html>
<body>
<div align="center">
<h1>商品一覧</h1>
<table border="1">
<tr>
<th>名前</th>
<th>メールアドレス</th>
<th>対応の有無</th>
</tr>
@foreach ($contacts as $contact)
<tr>
<td>{{ $contact->name }}</td>
<td>{{ $contact->email }}</td>
@if (!empty($contact->replyed))
<td>対応済み</td>
@else
<td>未対応</td>
@endif
<td><a href="{{ route('admin.contact.detail', $contact->id) }}">問い合わせ詳細</a></td>
</tr>
@endforeach
</table>
</div>
</body>
</html>
@endsection
