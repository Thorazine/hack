$(document).ready(function() {

	$('#header-toggle-menu').click(function() {
		if($('.menu').is(':visible')) {
			$('.menu').hide();
		}
		else {
			$('.menu').show();
		}
		
	});

});