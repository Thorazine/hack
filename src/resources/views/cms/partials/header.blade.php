<div class="header">
	<div class="holder" id="header-toggle-menu">
		<i class="fa fa-bars"></i>
	</div>

	<div class="menu-right">
		@if(Hack::user('first_name') || Hack::user('last_name'))
			<div class="holder text">
				<a href="{{ route('cms.user.show', ['id' => Hack::user('id')]) }}">{{ Hack::user('first_name') }} {{ Hack::user('last_name') }}</a>
			</div>
		@else
			<div class="holder text">
				<a href="{{ route('cms.user.show', ['id' => Hack::user('id')]) }}">Anonymous user</a>
			</div>
		@endif

		@if(Hack::user('image'))
			<div class="holder" id="portrait">
				<div style="background-image: url('{{ asset(Builder::asset(@Hack::user('gallery')->fullname)) }}');"></div>
			</div>
		@else
			<div class="holder">
				<i class="fa fa-user fa-2x"></i>
			</div>
		@endif
	</div>
</div>
