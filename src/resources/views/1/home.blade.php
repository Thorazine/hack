@extends('1.layouts.default')



@section('content')
	<div class="menu">
		<ul>
			<?php $first = true; ?>
			@foreach($page->menu->menuItems as $menu)
				<li @if($first) class="active" @endif>
					<div class="selector"></div>
					<a href="{{ $menu->external_url }}">
						{{ $menu->title }}
					</a>
				</li>
				<?php $first = false; ?>
			@endforeach
		</ul>
	</div>

	<section id="ometoon" class="hero">
		<div class="background" style="background-image: url('{{ $page->hoofdplaat->url }}')"></div>
		<div class="handle">
			<div class="chevron"></div>
		</div>
	</section>

	<section>
		<div class="content">
			<div class="wysiwyg">
				{!! $page->tekst_1 !!}
			</div>
		</div>
	</section>

	<div class="parallax" id="menu">
		<div class="parallax-slider">
			<img id="parallax1" src="{{ $page->achtergrond_1->url }}">
			<span class="parallax-heading">OmeToon</span>
		</div>
		<span class="heading">{!! $page->titel_1 !!}</span>
	</div>

	<section>
		<div class="content">
			
			<div class="card">
				<?php $items = App\Models\RestaurantMenu::where('active', 1)->orderBy('drag_order', 'asc')->orderBy('id')->get(); ?>
				@foreach($items as $item)
					<div class="price">
						{!! $item->price !!}
					</div>
					<div class="dish">
						{!! $item->dish !!}
					</div>
				@endforeach
				@for($i = count($items); $i < 19; $i++)
					<div class="dish"></div>
				@endfor
				<div class="left-line"></div>
				<div class="right-line"></div>
			</div>

			<div class="wysiwyg">
				{!! $page->tekst_2 !!}
			</div>
		</div>
	</section>

	<div class="parallax" id="reserveren">
		<div class="parallax-slider">
			<img id="parallax2" src="{{ $page->achtergrond_2->url }}">
			<span class="parallax-heading">OmeToon</span>
		</div>
		<span class="heading">{!! $page->titel_2 !!}</span>
	</div>

	<section>
		<div class="content">
			<div class="wysiwyg">
				{!! $page->tekst_3 !!}
			</div>
		</div>
	</section>

	<div class="parallax">
		<div class="parallax-slider">
			<img id="parallax3" src="{{ $page->bar->url }}">
		</div>
	</div>

	<section class="footer-top">

	</section>
	<section class="footer">
		<div class="content">

		</div>
	</section>

@stop