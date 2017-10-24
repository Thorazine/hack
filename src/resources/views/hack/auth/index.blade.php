@extends('hack::layouts.auth')


@section('content')
	<auth></auth>
@stop


@section('script')
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry&language=nl&region=NL&key={{ env('GOOGLE_KEY') }}"></script>
@stop
