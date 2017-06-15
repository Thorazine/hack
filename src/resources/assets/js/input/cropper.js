var cropper = {};
cropper.instances = {};
cropper.sending = false;

$(document).ready(function() {

	$('form').submit(function() {
		if(cropper.sending) {
			return false;
		}
	});

	$('[data-open-cropper]').click(function() {
		// get the base for the cropper
		var that = $(this).closest('.cropper');
		var key = cropper.getKey(that);

		// initiate the lot if a request comes in
		if(! cropper.instances[key]) {
			cropper.init(that, key);
		}
	});

	// go back to the gallery
	$('[data-open-gallery-tab]').click(function() {
		var that = $(this).closest('.cropper');
		var key = cropper.getKey(that);
		cropper.close(that, key);
		gallery.open(that, key);
	});

	$('[data-model-close]').click(function() {
		var that = $(this).closest('.cropper');
		var key = cropper.getKey(that);
		cropper.close(that, key);
	});

	// send tot the cropper on the server
	$('[data-cropper-send]').click(function() {
		var that = $(this).closest('.cropper');
		var key = cropper.getKey(that);
		cropper.gateway(that, key);
	});

	// send tot the cropper on the server
	$('.image .delete').click(function() {
		var that = $(this).closest('.cropper');
		var key = cropper.getKey(that);
		cropper.removeImage(that, key);
	});
});


cropper.init = function(that, key) {
	cropper.instances[key] = {};
	cropper.instances[key].resize_width = $(that).data('width');
	cropper.instances[key].resize_height = $(that).data('height');
	cropper.instances[key].modal = $(that).find('.modal-cropper');
	cropper.instances[key].width = $(that).data('width');
	cropper.instances[key].height = $(that).data('height');
};


cropper.load = function(that, key, url, id) {

	cropper.instances[key].id = id;

	if(! cropper.instances[key].cropper && url) {

		$(that).find('.cropper-image').prop('src', url);

		cropper.instances[key].cropper = $(that).find('.cropper-image').cropper({
	        viewMode: 1,
	        aspectRatio: cropper.instances[key].width / cropper.instances[key].height,
	        checkOrientation: false,
	        autoCropArea: 1,
	        checkCrossOrigin: false,
	        crop: function(e) {
				cropper.instances[key].x = e.x;
			    cropper.instances[key].y = e.y;
			    cropper.instances[key].width = e.width;
			    cropper.instances[key].height = e.height;
			},
	    });
	}
	else {
		$(cropper.instances[key].cropper).cropper('replace', url);
	}

	cropper.open(that, key);

    
};


cropper.getKey = function(that) {
	return $(that).data('key');
};


cropper.lock = function() {
	$('html, body').css('overflow', 'hidden');
};


cropper.unlock = function() {
	$('html, body').css('overflow', 'visible');
};


cropper.open = function(that, key) {
	$(cropper.instances[key].modal).fadeIn();
	cropper.lock();
};


cropper.close = function(that, key) {
	$(cropper.instances[key].modal).fadeOut();
	cropper.unlock();
};


cropper.setImage = function(that, key, url) {
	$(that).find('[data-image-button]').hide();
	$(that).find('[data-image-image] img').attr('src', url);
	$(that).find('[data-image-image]').show();
};


cropper.removeImage = function(that, key) {
	$(that).find('[data-image-button]').show();
	$(that).find('[data-image-image] img').attr('src', '');
	$(that).find('[data-image-image]').hide();
	$(that).find('.input-value').val('0'); // set for delete
};


cropper.gateway = function(that, key) {

	cropper.sending = true;

	var data = {
		id: cropper.instances[key].id,
		resize_width: cropper.instances[key].resize_width,
		resize_height: cropper.instances[key].resize_height,
		x: cropper.instances[key].x,
		y: cropper.instances[key].y,
		width: cropper.instances[key].width,
		height: cropper.instances[key].height,
	};	

	request($(that).data('upload-crop'), 'POST', data).then(function(response) {
		$(that).find('.input-value').val(response.data.id);
		cropper.setImage(that, key, response.data.thumbnail);
		cropper.sending = false;
	}, function(error) {
		cropper.sending = false;
	});
};