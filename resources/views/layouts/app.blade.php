<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@if (isAdminRoute())
<style>body{background-color: #FFDBC9;}</style>
@endif
</head>
<body>
<div id="app">
<nav class="navbar navbar-default navbar-static-top">
<div class="container">
<div class="navbar-header">

<!-- Collapsed Hamburger -->
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
<span class="sr-only">Toggle Navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>

<!-- Branding Image -->
@if (!isLogin())
<a class="navbar-brand" href="{{ url('/') }}">
{{ config('app.name', 'Laravel') }}</a>
@elseif (isLogin() && getUserType() == 'User')
<a class="navbar-brand" href="{{ url('/') }}">
{{ config('app.name', 'Laravel') }}</a>
@elseif (isLogin() && getUserType() == 'Admin')
<a class="navbar-brand" href="{{ route('admin.index') }}">
{{ config('app.name', 'Laravel') }}</a>
@endif
</div>

<div class="collapse navbar-collapse" id="app-navbar-collapse">
<!-- Left Side Of Navbar -->
<ul class="nav navbar-nav">
&nbsp;
</ul>

<!-- Right Side Of Navbar -->
<ul class="nav navbar-nav navbar-right">
<!-- Authentication Links -->
@if (isLogin() && !isAdminLogin())
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
{{ userInfo()->name }} <span class="caret"></span>
</a>
@elseif (!isLogin() && !isAdminLogin())
<li><a href="{{ route('login') }}">ログイン</a></li>
<li><a href="{{ route('register') }}">会員登録</a></li>
<li><a href="{{ route('contact.index') }}">問い合わせ</a></li>
@elseif (!isLogin() || isAdminLogin())
<li><a href="{{ route('admin.login') }}">Login</a></li>
@endif
@if (isLogin() && getUserType() == 'User')
<ul class="dropdown-menu">
<li>
<a href="{{ route('user.edit', Auth::id()) }}">user情報編集</a>
</li>
<li>
<a href="{{ route('addressee.index', Auth::id()) }}">userアドレス</a>
</li>
<li><a href="{{ route('contact.index') }}">問い合わせ</a></li>
<li>
<a href="{{ route('logout') }}"
onclick="event.preventDefault();
document.getElementById('logout-form').submit();">ログアウト</a>
	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
</li>
</ul>
@elseif (isLogin() && getUserType() == 'Admin')
<ul class="dropdown-menu">
<li>
<a href="{{ route('admin.order.index') }}">注文一覧</a>
</li>
<li>
<a href="{{ route('admin.contact.index') }}">お問合せ一覧</a>
</li>
<li>
<a href="{{ route('admin.user.index') }}">会員一覧</a>
</li>
<li>
<a href="{{ route('admin.logout') }}"
onclick="event.preventDefault();
document.getElementById('logout-form').submit();">ログアウト</a>
	<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
</li>
</ul>
@endif
</ul>
</div>
</div>
</nav>

@yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
