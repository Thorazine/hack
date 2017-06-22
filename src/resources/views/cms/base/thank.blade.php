@extends('hack::layouts.base')



@section('content')

	<div class="panel panel-primary horizontal-center-panel panel-form">
		<div class="panel-heading">
			<h3 class="panel-title">Thank you for using Hack!</h3>
		</div>
		<div class="panel-body">
			<p>Now lets get crack'n!</p>
			<a class="btn btn-primary pull-right" href="{{ route('cms.auth.index') }}">Login</a>
		</div>
	</div>

@stop