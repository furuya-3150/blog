<html>
<body>
<h1>商品一覧</h1>
<table border="1">
<tr>
<th>商品名</th>
<th>値段</th>
<th>在庫</th>
</tr>
@foreach ($items as $item)
<tr>
<td><a href="{{ route('detail.show', $item->id) }}">{{ $item->name }}</a></td>
<td>{{ $item->value}}円</td>
@if ($item->stock)
<td>在庫あり</td>
@else
<td>在庫無し</td>
@endif
</tr>
@endforeach
</table>
</body>
</html>
