@extends('hack::layouts.auth')



@section('content')

	<section class="auth">

		@if(! isset($latitude))
			<div class="panel panel-primary horizontal-center-panel panel-form" @if($locationPermission == 1) style="display: none;" @endif id="information">
				<div class="panel-heading">
					<h3 class="panel-title">Login - Set automatic location</h3>
				</div>
				<div class="panel-body">
					<p>This login system requires a location. Press the button below to activate the browsers location function.</p>
					<button class="btn btn-primary pull-right" id="location">Turn on location</button>
				</div>
			</div>

			<div class="panel panel-primary horizontal-center-panel panel-form" style="display: none;" id="error">
				<div class="panel-heading">
					<h3 class="panel-title">Login - Set manual location</h3>
				</div>
				<div class="panel-body">
					<p>It seems your browser failed to set your location. No worries, here is a map. Select your location.</p>

					<div class="form-group">
						<div class="input-group">
							<input type="text" placeholder="Type location or click on map" class="form-control" id="locationInput">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" id="setLocation">Lookup</button>
							</span>
						</div>
					</div>

					<div class="google-maps" id="error-map" data-service="latlong"></div>

					<div class="form-group" style="margin-top: 20px;">
						<button class="btn btn-primary pull-right" id="selectLocation">Accept location</button>
					</div>
				</div>
			</div>

			<div class="panel panel-primary horizontal-center-panel panel-form" @if($locationPermission == 0) style="display: none;" @endif id="authentication">

		@else 
			<div class="panel panel-primary horizontal-center-panel panel-form" id="authentication">
		@endif

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

					@if(! isset($latitude))
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