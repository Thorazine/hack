<!DOCTYPE html>
<head>

<link href="{{ asset('assets/cms/css/cms.css') }}" type="text/css" rel="stylesheet" media="screen"/>

<script src="https://use.fontawesome.com/5daec6a801.js"></script>

</head>
<body>
	@include('hack::tools.alert')

	@yield('content')

	@yield('script')

</body>
</html>