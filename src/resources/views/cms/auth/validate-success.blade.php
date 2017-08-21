@extends('hack::layouts.persistence')



@section('content')
	
	<div class="panel panel-primary horizontal-center-panel panel-form">
		<div class="panel-heading">
			<h3 class="panel-title">Login - Location verified</h3>
		</div>
		<div class="panel-body">
			<p>Thank you for verifing your your login attempt.</p>
			<p>Please click the button below to go to the main screen.</p>
			<a href="{{ route('cms.panel.index') }}" class="btn btn-primary">To Main screen</a>
		</div>
	</div>

@stop