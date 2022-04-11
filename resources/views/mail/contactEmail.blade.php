<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>お問合せいただきありがとうございます</title>
</head>
<body>
<h2>お問合せ内容を受け付けました</h2>
<p>名前</p>
{{ $data['name'] }}
<p>メールアドレス</p>
{{ $data['email'] }}
@if (!empty($data['item_name']))
<p>{{ $data['item_name'] }}に対してのお問合せ</p>
@endif
<p>内容</p>
{{ $data['content'] }}
</body>
</html>

