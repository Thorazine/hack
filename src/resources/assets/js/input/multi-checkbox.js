
$(document).ready(function() {

	// on click add or delete from the list
	$('.multi-checkbox').each(function() {
		$(this).find('.multi-checkbox-input').change(function(event) {
			if($(this).is(':checked')) {
				$(this).closest('.multi-checkbox').find('.multi-checkbox-list').append('<p data-id="'+$(this).val()+'">'+$(this).next().html()+'</p>') 
			}
			else {
				$(this).closest('.multi-checkbox').find('.multi-checkbox-list [data-id="'+$(this).val()+'"]').remove();
			}
		});
	});
	
});