<!DOCTYPE html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>{{ $page->title }}</title>
	<meta name="keywords" content="{{ $page->keywords }}">
	<meta name="description" content="{{ $page->description }}">
	<meta name="robots" content="{{ $page->robots }}">
	<meta property="og:title" content="{{ ($page->og_title) ? $page->og_title : $page->title  }}"/>
	<meta property="og:description" content="{{ ($page->og_description) ? $page->og_description : $page->description }}"/>
	<meta property="og:type" content="{{ ($page->og_type) ? $page->og_type : 'page' }}"/>
	<meta property="og:url" content="{{ Request::url() }}"/>
	
	@if($page->og_image->has())
	<meta property="og:image" content="{{ $page->og_image->url }}"/>
	<meta property="og:image:type" content="image/{{ $page->og_image->extension }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
	@endif
	@if($page->favicon->has())
	<link rel="shortcut icon" href="{{ $page->favicon }}" type="image/x-icon" />
	@endif
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1 minimal-ui">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/frontend.css') }}?version={{ (App::environment() === 'develop') ? rand(1,1000) : '' }}">

    @yield('css')
    
</head>
<body>

	@yield('content')

	@yield('script')

	@if(App::environment() === 'production')

	@else
		<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"></script>
	@endif

</body>
</html>