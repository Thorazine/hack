<div class="header">
	<div class="holder" id="header-toggle-menu">
		<i class="fa fa-bars"></i>
	</div>

	<div class="menu-right">
		@if(Cms::user('first_name') || Cms::user('last_name'))
			<div class="holder text">
				<a href="{{ route('cms.user.show', ['id' => Cms::user('id')]) }}">{{ Cms::user('first_name') }} {{ Cms::user('last_name') }}</a>
			</div>
		@else
			<div class="holder text">
				<a href="{{ route('cms.user.show', ['id' => Cms::user('id')]) }}">Anonymous user</a>
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