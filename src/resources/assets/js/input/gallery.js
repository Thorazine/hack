var gallery = {};
gallery.instances = {};
gallery.firstData = '';

$(document).ready(function() {

	$('[data-open-gallery]').click(function() {
		// get the base for the gallery
		var that = $(this).closest('.gallery');
		var key = gallery.getKey(that);

		// initiate the lot if a request comes in
		if(! gallery.instances[key]) {
			gallery.init(that, key);
		}

		gallery.open(that, key);
	});

	$('[data-model-close]').click(function() {
		var that = $(this).closest('.gallery');
		var key = gallery.getKey(that);
		gallery.close(that, key);
	});
});


var uploadTemplate = '' +
'<div class="item dz-preview dz-file-preview" title="" data-original="" data-id="">' +
	'<img data-dz-thumbnail />' +
	'<div class="dz-progress">' +
		'<div class="dz-upload" data-dz-uploadprogress style="width:0%;" title="Uploading..."></div>' +
		'<div class="dz-processing" title="Processing..."><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>' +
	'</div>' +
	'<div class="dz-remove" style="display:none;"><i class="fa fa-times"></i></div>' +
	// '<div class="dz-edit" style="display:none;"><i class="fa fa-pencil"></i></div>' +
'</div>';

gallery.init = function(that, key) {

	gallery.instances[key] = {};
	gallery.instances[key].dropzone = gallery.initDropzone(that, key);
	gallery.instances[key].modal = $(that).find('.modal-gallery');
	gallery.firstLoad(that, key);

	// put an event on the parent of items for a connection to the cropper
	$(gallery.instances[key].modal).find('.items-inner').bind('click', function(event) {
		
		// get the actual target
		var target = $(event.target).parent();

			// only go if there is an original link, else let it pass
			if($(target).data('original')) {
				gallery.close(that, key);
				cropper.load(that, key, $(target).data('original'), $(target).data('id'), $(target).attr('title'));
			}
	});
};


gallery.firstLoad = function(that, key) {
	if(gallery.firstData) {

	}
	else {
		gallery.gateway(that, key);
	}
};


gallery.gateway = function(that, key) {
	
    var data = {
    	filetype: 'image',
    };

	request($(that).data('gallery-api'), 'POST', data).then(function(response) {
		var html = '';
		$.each(response.data.data, function(index, values) {
			html += gallery.template(values.title, values.original, values.id, values.thumbnail);
		});

		$(gallery.instances[key].modal).find('.items-inner').html(html);
		gallery.bindOptions();
	}, function(error) {

	});
};


gallery.getKey = function(that) {
	return $(that).data('key');
};


gallery.lock = function() {
	$('html, body').css('overflow', 'hidden');
};


gallery.unlock = function() {
	$('html, body').css('overflow', 'visible');
};

gallery.open = function(that, key) {
	$(gallery.instances[key].modal).fadeIn();
	gallery.lock();
};

gallery.close = function(that, key) {
	$(gallery.instances[key].modal).fadeOut();
	gallery.unlock();
};


gallery.initDropzone = function(that, key) {

	// initiate dropzone
	return $(that).find('.model-modal-holder').dropzone({ 
		url: $('.gallery').data('upload-url'), 
		addRemoveLinks: true,
		previewsContainer: '#items-inner-'+key,
		previewTemplate: uploadTemplate,
		thumbnailWidth:100,
		thumbnailHeight:100,
		addRemoveLinks: false,
		init: function() {
			this.on('addedfile', function(file, response) {
				// move the newly created item to the top of the list
				console.log($(file.previewElement).parent().attr('class'))
				$(file.previewElement).parent().prepend(file.previewElement);
			});
			this.on('uploadprogress', function(file, progress, bytesSent) {
				// we want a countdown
				$(file.previewElement).find('.dz-upload').width((100 - progress)+'%');

				if(progress == 100) {
					$(file.previewElement).find('.dz-processing').show();
				}
			});
			this.on('success', function(file, response) {
				// take the response data and add it in the item
				// file.previewElement.id = response.id;
				// file.previewElement.filename = response.filename;
				// file.name = response.filename;
				// $(file.previewElement).attr('title', response.filename);
				// $(file.previewElement).data('original', response.original);
				// $(file.previewElement).data('id', response.id);
				// $(file.previewElement).find('.dz-progress').remove();
				// $(file.previewElement).find('.dz-edit').show();
				// $(file.previewElement).find('.dz-remove').show();
				// $(file.previewElement).addClass('item-id-'+response.id);

				$('.modal-gallery .items-inner').prepend(gallery.template(response.filename, response.original, response.id, $(file.previewElement).find('img').attr('src')));
				$(file.previewElement).remove();

				gallery.bindOptions();
			});
			this.on('sending', function(file, xhr, formData) {
				// Will send the filename along with the file as POST data.
				formData.append('filename', file.name);
				formData.append('_token', $('meta[name="_token"]').attr('content'));
			});
			this.on('error', function(file, error) {
				// add the error from the server to the item
				$(file.previewElement).prop('title', error);
			});
		}
	});
};

gallery.bindOptions = function() {
	$('.item .dz-edit').unbind('click').click(function(event) {
		alert('edit');
	});

	$('.item .dz-remove').unbind('click').click(function(event) {
		if(confirm(trans('confirm_delete'))) {
			gallery.remove(this, $(this).closest('.item').data('id'));
		}
	});
};

gallery.remove = function(that, id) {
	request($('.gallery').data('remove-api'), 'POST', {id: id}).then(function(response) {
		$('.modal-gallery .items-inner').find('[data-id="'+id+'"]').remove();
	});
};

gallery.template = function(title, original, id, thumbnail) {
	var html = '<div class="item" title="'+title+'" data-original="'+original+'" data-id="'+id+'">';
	html += '<img src="'+thumbnail+'">';
	html += '<div class="dz-remove"><i class="fa fa-times"></i></div>';
	// html += '<div class="dz-edit"><i class="fa fa-pencil"></i></div>';
	html += '</div>';
	return html;
}