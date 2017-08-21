<!DOCTYPE html>
<head>

<link href="{{ asset('assets/cms/css/cms.css') }}?version={{ (config('app.debug')) ? rand(1,1000) : $page->browser_cache_hash }}" type="text/css" rel="stylesheet" media="screen"/>

<script src="https://use.fontawesome.com/5daec6a801.js"></script>

</head>
<body>
	@include('hack::tools.alert')

	@yield('content')

	@yield('script')

</body>
</html>