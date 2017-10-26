@extends('hack::layouts.email')



@section('content')
	Hi there,<br>
	<br>
	We have noticed that somebody is trying to login with your account data from a new location
	you have not visited before. For security reasons we blocked the attempt and send you this
	email to verify that the login attempt is indeed permitted by you.<br>
	<br>
	<br>
	The data we could gather is this:<br>
	<br>
	Country: {{ $persistence['country'] }}<br>
	City: {{ $persistence['city'] }}<br>
	Device: {{ $persistence['device'] }}<br>
	Device type: {{ $persistence['device_type'] }}<br>
	Operating system: {{ $persistence['os'] }}<br>
	Browser: {{ $persistence['browser'] }}<br>
	<br>
	<br>
	If this is you you can confirm by clicking
	<a href="{{ route('hack.auth.validate', ['hash' => $persistence['verification_hash']]) }}">here</a><br>
	<br>
	If the attempt was not performed by you we recommend that you login <u>immediatly</u> and change your
	password because it has been comprimised. We also recommend changing your password on
	any site you used this password and advise you to not use a single password for multiple sites.<br>
	<br>
	<br>This is an automated mail from Hack CMS

@stop
