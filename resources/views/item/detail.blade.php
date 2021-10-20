<h1>商品詳細</h1>
<table border="1">
<tr>
<th>商品名</th>
<th>商品説明</th>
<th>値段</th>
<th>在庫の有無</th>
</tr>
<tr>
<td>{{ $item->name }}</td>
<td>{{ $item->description }}</td>
<td>{{ $item->value }}円</td>
@if ($item->stock)
<td>在庫あり</td>
@else
<td>在庫無し</td>
@endif
</tr>
</table>
