@if(session('alert-success') || @$alertSuccess)
<div class="alert alert-success alert-dismissible alert-timeout">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	{!! session('alert-success').@$alertSuccess !!}
</div>
@endif

@if(session('alert-info') || @$alertInfo)
<div class="alert alert-info alert-dismissible alert-timeout">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	{!! session('alert-info').@$alertInfo !!}
</div>
@endif

@if(session('alert-warning') || @$alertWarning)
<div class="alert alert-warning alert-dismissible alert-timeout">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	{!! session('alert-warning').@$alertWarning !!}
</div>
@endif

@if(session('alert-danger') || @$alertDanger)
<div class="alert alert-danger alert-dismissible alert-timeout">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	{!! session('alert-danger').@$alertDanger !!}
</div>
@endif

