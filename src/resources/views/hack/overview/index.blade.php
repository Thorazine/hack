@extends('hack::layouts.vue')

<?php
$menu = [
	[
		'title' => 'Dashboard',
		'subitems' => [],
	],
	[
		'title' => 'Menu item 2',
		'subitems' => [
			[
				'title' => 'Submenu item 1',
			],
			[
				'title' => 'Submenu item 2',
			],
		],
	]
];
?>

@section('content')
	<Hackmenu :items="'{{ json_encode($menu) }}'">

		<div slot="hackmenu-header" class="hackmenu-header hackmenu-select">
			<select>
				<option>Header</option>
			</select>
		</div>

		<div slot="hackmenu-footer" class="hackmenu-footer">
			<a class="" title="Settings">
				<i class="fa fa-gear"></i>
			</a>
			<a class="" title="Manual">
				<i class="fa fa-book"></i>
			</a>
			<a class="" title="FAQ">
				<i class="fa fa-question"></i>
			</a>
			<a class="" title="Logout">
				<i class="fa fa-power-off"></i>
			</a>
		</div>
	</Hackmenu>
	<Hackheader>
		Hack header
		<div slot="hackheader-user" class="hackheader-user">
			{{-- <div class="hackheader-user-image">
				<img src="http://icons.iconarchive.com/icons/visualpharm/must-have/256/User-icon.png">
			</div> --}}
			<div class="hackheader-user-image">
				<i class="fa fa-user-circle"></i>
			</div>
		</div>
	</Hackheader>
	<div class="model">
		<div class="model-content">
	 		model content
		</div>
	</div>
	<Hackfooter>
		bla bl
		<span slot="footer" class="hackfooter-information-version pull-right">Version {{ Hack::getVersion() }}</span>
	</Hackfooter>
@stop


@section('script')
	<script src="{{ asset('hack/js/en/hack-lang.js') }}"></script>
	<script src="{{ asset('js/hack.js') }}"></script>
@stop
