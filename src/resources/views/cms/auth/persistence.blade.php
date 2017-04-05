@extends('cms.layouts.persistence')



@section('content')
	
	<div class="panel panel-primary horizontal-center-panel panel-form">
		<div class="panel-heading">
			<h3 class="panel-title">Login - Location unknown</h3>
		</div>
		<div class="panel-body">
			<p>Hi there, you are trying to login from an unkown location.</p>
			<p>As a security precaution we would like you to verify your login attempt by confirming the sent email.</p>
			<a class="btn btn-primary pull-right" href="{{ route('cms.auth.persistence.resend') }}">Resend email</a>
		</div>
	</div>

@stop