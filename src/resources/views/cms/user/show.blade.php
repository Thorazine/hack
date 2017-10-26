@extends((@$isAjax) ? 'hack::layouts.ajax' : 'hack::layouts.cms')


@section('content')

	@include('hack::partials.menu')

	<div class="content user">

		@include('hack::partials.header')

		<div class="subheader">
			<div class="line"></div>
			<div class="line middle"></div>
			<a class="primary" href="{{ route('cms.user.edit', ['id' => $user->id]) }}" title="{{ trans('hack::cms.edit_your_data') }}">{{ trans('hack::cms.edit') }}</a>
		</div>

		<div class="row">
			<div class="col-sm-12">
				@if(Hack::user('image'))
					<div class="holder">
						<img src="{{ Builder::image(Hack::user('image')) }}">
					</div>
				@else
					<div class="holder">
						<i class="fa fa-user" style="font-size:100px;"></i>
					</div>
				@endif

				<div class="user-data">
					<h2>{{ Hack::user('first_name') }} {{ Hack::user('last_name') }}</h2>
					<p>
						@foreach(Hack::user('roles') as $index => $role)
							@if($index != 0),
							@endif
							{{ str_singular($role->name) }}
						@endforeach
					</p>
				</div>
			</div>
		</div>
		<h3>{{ trans('hack::modules.users.sessions') }}</h3>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>{{ trans('hack::modules.users.current') }}</th>
							<th>{{ trans('hack::modules.users.country') }}</th>
							<th>{{ trans('hack::modules.users.city') }}</th>
							<th>{{ trans('hack::modules.users.os') }}</th>
							<th>{{ trans('hack::modules.users.browser') }}</th>
							<th>{{ trans('hack::modules.users.device_type') }}</th>
							<th>{{ trans('hack::modules.users.device') }}</th>
							<th>{{ trans('hack::modules.users.last_used') }}</th>
							<th>{{ trans('hack::modules.users.remove') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><i class="fa fa-check"></i></td>
							<td>{{ Hack::user('persistence', 'country') }}</td>
							<td>{{ Hack::user('persistence', 'city') }}</td>
							<td>{{ Hack::user('persistence', 'os') }}</td>
							<td>@include('hack::user.browser', ['browser' => strtolower(Hack::user('persistence', 'browser'))]) {{ Hack::user('persistence', 'browser') }}</td>
							<td>{{ Hack::user('persistence', 'device_type') }}</td>
							<td>{{ Hack::user('persistence', 'device') }}</td>
							<td>{{ Hack::user('persistence', 'updated_at')->format('d-m-Y H:i:s') }}</td>
							<td><a href="{{ route('cms.auth.destroy') }}" class="btn btn-danger btn-xs">{{ trans('hack::cms.logout') }}</a></td>
						</tr>

						@foreach($user->persistences as $persistence)
							@if(Hack::user('persistence', 'id') != $persistence->id)
								<tr>
									<td></td>
									<td>{{ $persistence->country }}</td>
									<td>{{ $persistence->city }}</td>
									<td>{{ $persistence->os }}</td>
									<td>@include('hack::user.browser', ['browser' => strtolower($persistence->browser)]) {{ $persistence->browser }}</td>
									<td>{{ $persistence->device_type }}</td>
									<td>{{ $persistence->device }}</td>
									<td>{{ $persistence->updated_at->format('d-m-Y H:i:s') }}</td>
									<td><a href="{{ route('cms.user.destroy', ['id' => $persistence->id]) }}" class="btn btn-danger btn-xs model-delete">{{ trans('hack::modules.users.invalidate_session') }}</a></td>
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
