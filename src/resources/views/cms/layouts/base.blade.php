<!DOCTYPE html>
<head>

<meta name="_token" content="{{ csrf_token() }}">

<link href="{{ asset('assets/cms/css/cms.css') }}" type="text/css" rel="stylesheet" media="screen"/>

<script src="https://use.fontawesome.com/5daec6a801.js"></script>

{{-- <script src="{{ asset('assets/cms/js/cms.js') }}"></script>
 --}}
</head>
<body>

	@include('hack::tools.alert')
	
	@yield('content')

	@yield('script')
</body>
</html>