@extends('layouts.app')
@if ($errors->any())
	<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	</div>
@endif
@if (session('flash_message'))
{{ session('flash_message') }}
@endif
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>csvファイルインポート</title>
</head>
<body>
<div align="center">
<h3>CSVファイルアップロード</h3>
<form method="post" action="{{ route('admin.data.import_csv') }}" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="file" name="csvfile">
<input type="submit" value="アップロード">
</form>
</div>
</body>
</html>
@endsection
