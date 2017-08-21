@extends('hack::layouts.auth')



@section('content')

	<?php
		// set the location permission to the variable always
		if(! $locationPermission) {
			$locationPermission = session('locationPermission');
		}
	?>

	<section class="auth">

		@include('hack::auth.partials.location')

			<div class="panel-heading">
				<h3 class="panel-title">Login</h3>
			</div>
			<div class="panel-body" >

				@if ($errors->any())
					<div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif

				@if(session('alert-error'))
					<div class="alert alert-danger">{{ session('alert-error') }}</div>
				@endif

				{!! Form::open(['route' => 'cms.auth.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}

					{!! Form::hidden('latitude', @$latitude, ['id' => 'latitude']) !!}
					{!! Form::hidden('longitude', @$longitude, ['id' => 'longitude']) !!}

					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Email address</label>
						<div class="col-sm-8">
							{!! Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Email address']) !!}
							{!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="col-sm-4 control-label">Password</label>
						<div class="col-sm-8">
							{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
							{!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
						</div>
					</div>

					@if(! isset($latitude) && ! session('alert-error'))
						<button type="submit" class="btn btn-primary pull-right" disabled="disabled" id="submit">One moment please, requesting location <i class="fa fa-spinner fa-spin"></i></button>
					@else
						<button type="submit" class="btn btn-primary pull-right" id="submit">Login</button>
					@endif
				{!! Form::close() !!}

			</div>
		</div>
	</section>
@stop


@section('script')

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry&language=nl&region=NL&key={{ env('GOOGLE_KEY') }}"></script>

@stop