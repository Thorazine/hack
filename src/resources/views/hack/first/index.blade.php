@extends('hack::layouts.vue')


@section('content')
	<First></First>
@stop


@section('script')
	<script src="{{ asset('hack/js/en/first-lang.js') }}"></script>
	<script src="{{ asset('hack/js/first.js') }}"></script>
@stop
