<!DOCTYPE html>
<head>
	<meta name="robots" content="no index, no follow">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('hack/css/hack.css') }}" type="text/css" rel="stylesheet" media="screen"/>
</head>
<body>
	<div id="app">
		@yield('content')
	</div>

	<script>
		window.BASE_URL = "{{ env('APP_URL') }}";
		window.trans = (string) => _.get(window.i18n, string);
	</script>
	<script src="{{ asset('hack/js/auth-lang.js') }}"></script>
	<script src="{{ asset('hack/js/login.js') }}"></script>
	<script src="https://use.fontawesome.com/5daec6a801.js"></script>

	@yield('script')

	@if(env('APP_DEBUG'))
		<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"></script>
	@endif
</body>
</html>
