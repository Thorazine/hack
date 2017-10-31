@extends('hack::layouts.vue')


@section('content')
	<Setting>

		<div slot="hackmenu-header" class="hackmenu-header hackmenu-select">
			<select>
				<option>Header</option>
			</select>
		</div>
	</Setting>
@stop


@section('script')
	<script src="{{ asset('hack/js/en/hack-lang.js') }}"></script>
	<script src="{{ asset('js/setting.js') }}"></script>
@stop
