@extends('hack::layouts.vue')


@section('content')
	<Persistence></Persistence>
@stop


@section('script')
	<script src="{{ asset('hack/js/auth-lang.js') }}"></script>
	<script src="{{ asset('hack/js/persistence.js') }}"></script>
@stop
