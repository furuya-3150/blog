@extends('layouts.app')
@section('content')
<html>
<body>
<div align="center">
<h1>問い合わせ詳細</h1>
<table border="1">
<tr>
<th>名前</th>
<th>メールアドレス</th>
<th>問い合わせ商品</th>
<th>問い合わせ内容</th>
<th>対応の有無</th>
</tr>
<tr>
<td>{{ $contact->name }}</td>
<td>{{ $contact->email }}</td>
@if (!empty($contact->payment->cart->item->name))
<td>{{ $contact->payment->cart->item->name}}</td>
@else
<td>無</td>
@endif
<td>{{ $contact->content }}</td>
@if (!empty($contact->replyed))
<td>対応済み</td>
@else
<td>未対応</td>
@endif
</tr>
</table>
</div>
</body>
</html>
@endsection
