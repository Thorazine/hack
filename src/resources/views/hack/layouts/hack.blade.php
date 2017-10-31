<!DOCTYPE html>
<head>
	<title>Hack</title>
	<meta name="robots" content="no index, no follow">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('css/hack.css') }}" type="text/css" rel="stylesheet" media="screen"/>
</head>
<body>
	<div id="app">
		<Hackmenu :items="'{{ json_encode(Hack::menu()) }}'">

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
		 		@yield('content')
			</div>
		</div>
		<Hackfooter>
			bla bl
			<span slot="footer" class="hackfooter-information-version pull-right">Version {{ Hack::getVersion() }}</span>
		</Hackfooter>
	</div>

	<script>
		window.BASE_URL = "{{ env('APP_URL') }}";
		window.trans = (string) => _.get(window.i18n, string);
	</script>
	<script src="https://use.fontawesome.com/5daec6a801.js"></script>
	<script src="{{ asset('hack/js/en/hack-lang.js') }}"></script>
	<script src="{{ asset('js/hack.js') }}"></script>

	@yield('script')

	@if(env('APP_DEBUG'))
		<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"></script>
	@endif
</body>
</html>


