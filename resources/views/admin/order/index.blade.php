@extends('layouts.app');
@section('content');
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
<html>
<body>
<div align="center">
<h2>検索条件</h2>
<form action="{{ route('admin.order.search') }}" method="post">
{{ csrf_field() }}
<h3>注文日</h3>
<p>開始日<input type="date" name="start_date"></p>
<p>終了日<input type="date" name="end_date"></p>
<h3>お届け先指名</h3>
<input type="text" name="name">
</br>
<input type="submit" name="subumit" value="検索">
</form>
@if (!empty($purchase_historys))
<h2>注文一覧</h2>
<table border="1">
<tr>
<th>注文日</th>
<th>合計金額</th>
<th>お届け先の氏名</th>
<th>注文ステータス</th>
</tr>
@foreach ($purchase_historys as $purchase_history)
<tr>
<td>{{ $purchase_history->created_at }}</td>
<td>{{ $purchase_history->total}}円</td>
<td>{{ $purchase_history->name}}</td>
@if (!empty($purchase_history->refunded_at))
<td>返金済み</td>
@elseif (is_null($purchase_history->in_delivary))
<td>未配達</td>
@elseif (!empty($purchase_history->in_delivary) && is_null($purchase_history->delivared_at))
<td>配達中</td>
@elseif (!empty($purchase_history->delivared_at))
<td>配達済み</td>
@endif
<td><a href="{{ route('admin.order.detail', $purchase_history->id) }}">注文情報詳細</a></td>
</tr>
@endforeach
@else
<p>注文履歴がありません</p>
@endif
</table>
<a href="{{ route('admin.order.export_csv') }}">csvファイルダウンロード</a>
</div>
</body>
</html>
@endsection
