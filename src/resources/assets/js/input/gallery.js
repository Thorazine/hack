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
		'<div class="dz-upload" data-dz-uploadprogress></div>' +
	'</div>' +
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
				cropper.load(that, key, $(target).data('original'), $(target).data('id'));
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
			html += '<div class="item" title="'+values.title+'" data-original="'+values.original+'" data-id="'+values.id+'">';
			html += '<img src="'+values.thumbnail+'">';
			html += '</div>';
		});

		$(gallery.instances[key].modal).find('.items-inner').html(html);

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
		previewsContainer: '.items-inner',
		previewTemplate: uploadTemplate,
		thumbnailWidth:100,
		thumbnailHeight:100,
		addRemoveLinks: false,
		removedfile: function(file) {
			$.ajax({
				type: 'POST',
				url: galleryDeletePath,
				data: "id="+file.previewElement.id,
				dataType: 'html'
			});
			var _ref;
			return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0; 
		},
		init: function() {
			this.on('addedfile', function(file, response) {
				// move the newly created item to the top of the list
				$(file.previewElement).parent().prepend(file.previewElement);
			});
			this.on('uploadprogress', function(file, progress, bytesSent) {
				// we want a countdown
				$(file.previewElement).find('.dz-upload').width((100 - progress)+'%');
			});
			this.on('success', function(file, response) {
				// take the response data and add it in the item
				file.previewElement.id = response.id;
				file.previewElement.filename = response.filename;
				file.name = response.filename;
				$(file.previewElement).attr('title', response.filename);
				$(file.previewElement).data('original', response.original);
				$(file.previewElement).data('id', response.id);
				$(file.previewElement).find('.dz-progress').remove();
			});
			this.on('sending', function(file, xhr, formData) {
				// Will send the filesize along with the file as POST data.
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