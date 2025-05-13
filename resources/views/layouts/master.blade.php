<?php
setcookie('cross-site-cookie', 'name', ['samesite' => 'Strict', 'secure' => true, 'httponly' =>true]);
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
	<meta charset="utf-8">
	<title>彰化縣性別平等教育資源網 - @yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<meta name="description" content="This is meta description">
	<meta name="author" content="Themefisher">
    <meta http-equiv="Content-Security-Policy" content="script-src * 'unsafe-inline' 'unsafe-eval';">
	<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
  
  <!-- theme meta -->
  <meta name="theme-name" content="reporter" />

	<!-- # Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- # CSS Plugins -->
	<link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
	<link href="{{ asset('plugins/bootstrap/bootstrap-icons.css') }}" rel="stylesheet">

	<!-- venobox-->
	<link rel="stylesheet" href="{{ asset('venobox/venobox.min.css') }}" type="text/css" media="screen" />

	<script type="text/javascript" src="{{ asset('venobox/venobox.min.js') }}"></script>

	<!-- # Main Style Sheet -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

@include('layouts.header')

<main>
@yield('content')
</main>

@include('layouts.footer')


<!-- # JS Plugins -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Main Script -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/my.js') }}"></script>
@yield('my_js')
</body>
</html>