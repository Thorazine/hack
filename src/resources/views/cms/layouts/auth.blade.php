<!DOCTYPE html>
<head>

<meta name="_token" content="{{ csrf_token() }}">

<link href="{{ asset('assets/cms/css/cms.css') }}?version={{ (config('app.debug')) ? rand(1,1000) : Cms::site('browser_cache_hash') }}" type="text/css" rel="stylesheet" media="screen"/>

<script src="https://use.fontawesome.com/5daec6a801.js"></script>

<script src="{{ asset('assets/cms/js/auth.js') }}?version={{ (config('app.debug')) ? rand(1,1000) : Cms::site('browser_cache_hash') }}"></script>


</head>
<body>

	@include('hack::tools.alert')
	
	@yield('content')

	@yield('script')

</body>
</html>