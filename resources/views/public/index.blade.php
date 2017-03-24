@extends('public.block.main')
<!-- title off page -->
@section('title')
    {{ trans('public.title-public') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    @include('public.detail')
@endsection
<!-- js used for page -->
