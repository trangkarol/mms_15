<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <!-- start css -->
        @section('contentCss')
        {{ Html::style('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
        {{ Html::style('/bower_components/components-font-awesome/css/font-awesome.min.css') }}
        {{ Html::style('/css/app.css') }}
        @show
        <!-- end csss -->
    </head>
    <body>
