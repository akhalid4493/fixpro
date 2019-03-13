<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ url(settings('favicon')) }}">
    
    <title>@yield('title', 'Home') || {{ settings('app_name_en') }}</title>

	<link rel="stylesheet" type="text/css" href="{{ url('front/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('front/css/responsive.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet" type="text/css" />

	<!-- Fix Internet Explorer-->
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="vendor/html5shiv.js"></script>
	<script src="vendor/respond.js"></script>
	<![endif]-->

	<style>
	    body{
	        font-family: 'Cairo', sans-serif !important;
	    }
    </style>

    @yield('css')

</head>