$(document).ready(function() {

	if($('.model [name="width"]').length && $('.model [name="height"]').length && $('.model .aspect-ratio').length) {

		$('.model .aspect-ratio .ratio').change(function() {
			if($(this).val()) {
				$('[name="height"]').val(Math.ceil($('[name="width"]').val() / eval($(this).val())));
			}
		});

		$('[name="width"]').change(function() {
			if($('.model .aspect-ratio .ratio').val()) {
				$('[name="height"]').val(Math.ceil($('[name="width"]').val() / eval($('.model .aspect-ratio .ratio').val())));
			}
		});

		$('[name="height"]').change(function() {
			if($('.model .aspect-ratio .ratio').val()) {
				$('[name="width"]').val(Math.ceil($('[name="height"]').val() * eval($('.model .aspect-ratio .ratio').val())));
			}
		});
	}
	
});