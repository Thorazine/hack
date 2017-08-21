<!-- Start library -->
<div class="model-modal modal-gallery">
	<div class="model-modal-header">
		<div class="brand">
			Gallery
		</div>

		<div class="button-text model-modal-close" data-model-close>
			&times;
		</div>

		<span class="title">Drop images to add them</span>
	</div>
	<div class="model-modal-holder">

		<div class="items-inner" id="items-inner-{{ $key }}"></div>

	</div>
	<div class="model-modal-footer">
		<div class="">
			{{ Builder::formatSizeUnits(disk_free_space('/'))  }}
		</div>
	</div>
</div>
<!-- End library -->