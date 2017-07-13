<!DOCTYPE html>
<head>

<title>{{ Cms::site('title') }} - CMS</title>
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1 minimal-ui">
<link rel="shortcut icon" href="{{ Builder::image(Cms::site('favicon')) }}" type="image/x-icon" />

<meta name="_token" content="{{ csrf_token() }}">

<link href="{{ asset('assets/cms/css/cms.css') }}?version={{ (App::environment() === 'develop') ? rand(1,1000) : '' }}" type="text/css" rel="stylesheet" media="screen"/>

<script src="{{ asset('assets/cms/js/cms.js') }}?version={{ (App::environment() === 'develop') ? rand(1,1000) : '' }}"></script>

<script src="https://use.fontawesome.com/5daec6a801.js"></script>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

</head>
<body class="sandstone">

	@include('hack::partials.cms-loader')

	@include('hack::tools.alert')
	
	@yield('content')

	@yield('modal')

	@include('hack::tools.js')

	@yield('script')
</body>
</html>