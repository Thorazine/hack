<!DOCTYPE html>
<head>

<!-- ##############################################
    __  _____   ________ __                       
   / / / /   | / ____/ //_/   _________ ___  _____
  / /_/ / /| |/ /   / ,<     / ___/ __ `__ \/ ___/
 / __  / ___ / /___/ /| |   / /__/ / / / / (__  ) 
/_/ /_/_/  |_\____/_/ |_|   \___/_/ /_/ /_/____/  
                                                  
############################################### -->

<title>{{ Cms::site('title') }} - CMS</title>
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1 minimal-ui">
<link rel="shortcut icon" href="{{ Builder::image(Cms::site('favicon')) }}" type="image/x-icon" />

<meta name="_token" content="{{ csrf_token() }}">

<link href="{{ asset('assets/cms/css/cms.css') }}?version={{ (config('app.debug')) ? rand(1,1000) : Cms::site('browser_cache_hash') }}" type="text/css" rel="stylesheet" media="screen"/>

<script src="{{ asset('assets/cms/js/cms.js') }}?version={{ (config('app.debug')) ? rand(1,1000) : Cms::site('browser_cache_hash') }}"></script>

<script src="https://use.fontawesome.com/5daec6a801.js"></script>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

</head>
<body>

	@include('hack::partials.cms-loader')

	@include('hack::tools.alert')
	
	@yield('content')

	@yield('modal')

	@include('hack::tools.js')

	@yield('script')
</body>
</html>