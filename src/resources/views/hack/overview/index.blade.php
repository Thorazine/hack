@extends('hack::layouts.vue')


@section('content')
	<Hackmenu></Hackmenu>
	<Hackheader>
		Hack header
	</Hackheader>
	<div class="model">
		<div class="model-content">
	 		model content
		</div>
	</div>
	<Hackfooter>
		bla bl
		<span slot="footer" class="version">Version {{ Hack::getVersion() }}</span>
	</Hackfooter>
@stop


@section('script')
	<script src="{{ asset('hack/js/en/hack-lang.js') }}"></script>
	<script src="{{ asset('js/hack.js') }}"></script>
@stop
