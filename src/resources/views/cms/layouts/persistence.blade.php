<!DOCTYPE html>
<head>

<link href="{{ asset('assets/cms/css/cms.css') }}" type="text/css" rel="stylesheet" media="screen"/>

</head>
<body>
	@include('hack::tools.alert')

	@yield('content')

	@yield('script')

</body>
</html>