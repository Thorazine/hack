<div class="header">
	<div class="holder" id="header-toggle-menu">
		<i class="fa fa-chevron-left"></i>
	</div>

	<div class="menu-right">
		@if(Cms::user('first_name') || Cms::user('last_name'))
			<div class="holder text">
				{{ Cms::user('first_name') }} {{ Cms::user('last_name') }}
			</div>
		@else
			<div class="holder text">
				Anonymous user
			</div>
		@endif

		@if(Cms::user('image'))
			<div class="holder" id="portrait">
				<div style="background-image: url('{{ asset(Builder::asset(@Cms::user('gallery')->fullname)) }}');"></div>
			</div>
		@else
			<div class="holder">
				<i class="fa fa-user fa-2x"></i>
			</div>
		@endif
	</div>
</div>