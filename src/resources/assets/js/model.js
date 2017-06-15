var model = {};

$(document).ready(function() {

	/**
	 * delete a resource 
	 */
	$('.model-delete').click(function(event) {

		if(! confirm(trans('confirm_delete'))) {
			return false;
		}

		event.preventDefault();

		var that = this;
		var originalHtml = $(this).html();

		$(this).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');

		request($(this).prop('href'), 'DELETE').then(function(response) {

			$(that).closest('tr').remove();
			
		}, function(error) {

			$(that).html(error.data.message);

			setInterval(function() {
				$(that).html(originalHtml);
			}, 2000);

		});
		
	});


	/**
	 * create a slug from a title
	 */
	if($('.model [name="key"]').length && $('.model [name="label"]').length) {

		$('.model [name="label"]').keyup(function(event) {
			var text = $('.model [name="label"]').val();
			var key = text.toString().toLowerCase()
			    .replace(/\s+/g, '_')           // Replace spaces with _
			    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
			    .replace(/\-\-+/g, '_')         // Replace multiple - with single _
			    .replace(/\_\_+/g, '_')         // Replace multiple _ with single _
			    .replace(/^-+/, '')             // Trim - from start of text
			    .replace(/-+$/, '');            // Trim - from end of text

			$('.model [name="key"]').val(key);
		});

	}

	$('.order').sortable({
        helper: function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index)
            {
                // Set helper cell sizes to match the original sizes
                $(this).width($originals.eq(index).width()).css('background-color', '#FFF');
            });
            return $helper;
        },
        placeholder: "ui-state-highlight",
        handle: '.handle',
        update: function (event, ui) {
            var order = {};

            var i = 1;

            $(this).find('tr').each(function(event, ui) {
                order[i] = $(this).data('id');
                i++;
            });

            request($(this).data('order-url'), 'post', {order: order}).then(function(response) {

            }, function(error) {
                console.error("Error in request", error);
            });
        },
    });


    $('#q-button').click(function(event) {
    	// History.pushState({state:1}, "State 1", "?state=1");
    	model.search();
    });

    $('#q').keypress(function(event) {
    	if(event.which == 13) {
    		model.search();
    	}
    });

    $('#data-header th a').click(function(event) {
    	event.preventDefault();
    	$(this).data('dir', ($(this).data('dir') == 'asc') ? 'desc' : 'asc');
    	model.search($(this).data('order'), $(this).data('dir'));
    });

    $('#q-clear').click(function(event) {
    	$('#q').val('');
    	model.search();
    });

	model.modelPaginateBind();    
});

model.modelPaginateBind = function() 
{
	$('.paginate a').click(function(event) {
    	event.preventDefault();
    	model.search();
    });
};


model.search = function(order, dir)
{
	order = (typeof order === "undefined") ? '' : order;
	dir = (typeof dir === "undefined") ? '' : dir;

	url = $('#q-button').data('href')+'?q='+$('#q').val()+'&order='+order+'&dir='+dir;

	history.replaceState({state:1}, "Search", url);

	request(url, 'GET').then(function(response) {
		$('#dataset').html(response.data.dataset);
		$('.pagination').html(response.data.paginate);
		model.modelPaginateBind(); 
	    $('html,body').animate({ scrollTop: 0 }, 200);
	}, function(error) {
		alert(error);
	});
};

model.order = function(url) 
{

}