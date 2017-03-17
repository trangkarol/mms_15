<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		<title>@yield('title')</title>
		<!-- start css -->
		{{ Html::style('/assets/css/common/bootstrap.css') }}
		{{ Html::style('/assets/css/common/bootstrap.min.css') }}
		{{ Html::style('/font-awesome/css/font-awesome.min.css') }}
		{{ Html::style('/assets/css/common/common.css') }}
		{{ Html::style('/css/app.css') }}
		
		@yield('contentCss')
		<!-- end csss -->
		<!-- start js -->	
		{{ Html::script('/assets/js/common/jquery.js') }}
		<!-- end js -->
	</head>
	<body>
