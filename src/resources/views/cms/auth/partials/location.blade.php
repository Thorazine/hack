@if($locationPermission == 0)

<div class="panel panel-primary horizontal-center-panel panel-form" style="display: @if($locationPermission == 0) block @else none @endif;" id="information">
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

<div class="panel panel-primary horizontal-center-panel panel-form" style="display: none;" id="authentication">
@else 
<div class="panel panel-primary horizontal-center-panel panel-form" id="authentication">
@endif