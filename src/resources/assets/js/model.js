var model = {};

model.page = 1;
model.order = '';
model.q = '';
model.dir = 'asc';
model.filters = {};

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
    	model.q = $('#q').val();
    	model.search();
    });

    $('#q').keypress(function(event) {
    	if(event.which == 13) {
    		model.q = $(this).val();
    		model.search();
    	}
    });

    $('#data-header th a').click(function(event) {
    	event.preventDefault();

    	model.order = $(this).data('order');
    	model.dir = ($(this).data('dir') == 'asc') ? 'desc' : 'asc';

    	$(this).data('dir', model.dir);

    	$('thead th i').remove(); // 
    	$(this).html($(this).text()+' <i class="fa fa-chevron-'+((model.dir == 'asc') ? 'down' : 'up')+'"></i>');

    	model.search();
    });

    $('#q-clear').click(function(event) {
    	model.q = '';
    	model.page = 1;
		model.order = '';
		model.dir = 'asc';
		model.filters = {};
    	model.search();

    	$('.model-filter').each(function() {
    		$(this).val('');
    	});
    });

    // get the initial values for search, sort, order and page
    var url = new URL(window.location.href);
	model.q = (url.searchParams.get("search")) ? url.searchParams.get("search") : model.q;
	model.order = (url.searchParams.get("order")) ? url.searchParams.get("order") : model.order;
	model.dir = (url.searchParams.get("dir")) ? url.searchParams.get("dir") : model.dir;
	model.page = (url.searchParams.get("page")) ? url.searchParams.get("page") : model.page;

	$('.model-filter').each(function() {
		var filter = $(this).data('filter');
		if(url.searchParams.has('filters['+filter+']')) {
			model.filters[filter] = url.searchParams.get('filters['+filter+']');
			$('#filter-'+filter).val(model.filters[filter]);
		}
	});

	model.modelPaginateBind();  

	model.buildFilters()


	$('.model-filter').change(function(event) {
		event.preventDefault();
		if($(this).val()) {
			model.filters[$(this).data('filter')] = $(this).val();
		}
		else {
			delete model.filters[$(this).data('filter')];
		}
		model.search();
	});
});


model.search = function()
{
	url = $('#q-button').data('href')+'?q='+model.q+'&order='+model.order+'&page='+model.page+'&dir='+model.dir+model.buildFilters();

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

model.modelPaginateBind = function() 
{
	$('.paginate a').click(function(event) {
    	event.preventDefault();

    	var url = new URL($(this).attr('href'));
		model.page = (url.searchParams.get("page")) ? url.searchParams.get("page") : model.page;

    	model.search();
    });
};

model.buildFilters = function() {
	var url = '';
	$.each(model.filters, function(key, value) {
		if(value) {
			url += '&filters['+key+']='+value;
		}
	});
	return url;
};