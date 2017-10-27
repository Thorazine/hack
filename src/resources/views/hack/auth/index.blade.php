@extends('hack::layouts.vue')


@section('content')
	<Auth></Auth>
@stop


@section('script')
	<script src="{{ asset('hack/js/en/auth-lang.js') }}"></script>
	<script src="{{ asset('hack/js/auth.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry&language=nl&region=NL&key={{ env('GOOGLE_KEY') }}"></script>
@stop
