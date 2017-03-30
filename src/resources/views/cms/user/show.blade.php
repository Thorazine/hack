@extends((@$isAjax) ? 'cms.layouts.ajax' : 'cms.layouts.cms')


@section('content')

	@include('cms.partials.menu')
	
	<div class="content user">

		@include('cms.partials.header')

		<div class="subheader">
			<a class="primary" href="{{ route('cms.user.edit', ['id' => $user->id]) }}" title="Edit your data">Edit</a>
		</div>

		<div class="row">
			<div class="col-sm-12">
				@if(Cms::user('image'))
					<div class="holder">
						<img src="{{ Builder::image(Cms::user('image')) }}">
					</div>
				@else
					<div class="holder">
						<i class="fa fa-user"></i>
					</div>
				@endif

				<div class="user-data">
					<h2>{{ Cms::user('first_name') }} {{ Cms::user('last_name') }}</h2>
					<p>
						@foreach(Cms::user('roles') as $index => $role)
							@if($index != 0), 
							@endif
							{{ str_singular($role->name) }}
						@endforeach
					</p>
				</div>
			</div>
		</div>
		<h3>Sessions</h3>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Current</th>
							<th>Country</th>
							<th>City</th>
							<th>OS</th>
							<th>Browser</th>
							<th>Device type</th>
							<th>Device</th>
							<th>Last used</th>
							<th>Remove</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><i class="fa fa-check"></i></td>
							<td>{{ Cms::user('persistence', 'country') }}</td>
							<td>{{ Cms::user('persistence', 'city') }}</td>
							<td>{{ Cms::user('persistence', 'os') }}</td>
							<td>@include('cms.user.browser', ['browser' => strtolower(Cms::user('persistence', 'browser'))]) {{ Cms::user('persistence', 'browser') }}</td>
							<td>{{ Cms::user('persistence', 'device_type') }}</td>
							<td>{{ Cms::user('persistence', 'device') }}</td>
							<td>{{ Cms::user('persistence', 'updated_at')->format('d-m-Y H:i:s') }}</td>
							<td><a href="{{ route('cms.auth.destroy') }}" class="btn btn-danger btn-xs">Logout</a></td>
						</tr>

						@foreach($user->persistences as $persistence)
							@if(Cms::user('persistence', 'id') != $persistence->id)
								<tr>
									<td></td>
									<td>{{ $persistence->country }}</td>
									<td>{{ $persistence->city }}</td>
									<td>{{ $persistence->os }}</td>
									<td>@include('cms.user.browser', ['browser' => strtolower($persistence->browser)]) {{ $persistence->browser }}</td>
									<td>{{ $persistence->device_type }}</td>
									<td>{{ $persistence->device }}</td>
									<td>{{ $persistence->updated_at->format('d-m-Y H:i:s') }}</td>
									<td><a href="{{ route('cms.user.destroy', ['id' => $persistence->id]) }}" class="btn btn-danger btn-xs model-delete">Invalidate session</a></td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="map">
					<div id="map"></div>
				</div>
			</div>
		</div>
	</div>

@stop


@section('script')

<script>
	function initMap() {

        var mapOptions = {
			center: new google.maps.LatLng(0, 0),
			zoom: 1,
			minZoom: 1
		};

		var map = new google.maps.Map(document.getElementById('map'), mapOptions);

		var allowedBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng(85, -180),	// top left corner of map
			new google.maps.LatLng(-85, 180)	// bottom right corner
		);

		var k = 5.0; 
		var n = allowedBounds .getNorthEast().lat() - k;
		var e = allowedBounds .getNorthEast().lng() - k;
		var s = allowedBounds .getSouthWest().lat() + k;
		var w = allowedBounds .getSouthWest().lng() + k;
		var neNew = new google.maps.LatLng( n, e );
		var swNew = new google.maps.LatLng( s, w );
		boundsNew = new google.maps.LatLngBounds( swNew, neNew );
		map .fitBounds(boundsNew);

		@foreach($user->persistences as $persistence)
	        var marker = new google.maps.Marker({
				position: { lat: {{ $persistence->latitude }}, lng: {{ $persistence->longitude }} },
				map: map,
				title: '{{ $persistence->country }} - {{ $persistence->city }}'
	        });
	    @endforeach
    }
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry&language=nl&region=NL&key={{ env('GOOGLE_KEY') }}&callback=initMap"></script>

@stop
