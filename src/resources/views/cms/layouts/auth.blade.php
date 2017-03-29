<!DOCTYPE html>
<head>

<meta name="_token" content="{{ csrf_token() }}">

<link href="{{ asset('assets/cms/css/cms.css') }}" type="text/css" rel="stylesheet" media="screen"/>

<script src="{{ asset('assets/cms/js/auth.js') }}"></script>


</head>
<body>

	@include('cms.tools.alert')
	
	@yield('content')

	@yield('script')

</body>
</html>