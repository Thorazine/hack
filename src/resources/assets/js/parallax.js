var hero = new Waypoint.Inview({
	element: $('#ometoon')[0],
	enter: function(direction) {
		$(this.element).find('.background').show();
	},
	exited: function(direction) {
		$(this.element).find('.background').hide();
	}
});

var parallax1 = new Waypoint.Inview({
	element: $('#parallax1')[0],
	enter: function(direction) {
		$(this.element).find('.parallax-slider').show();
	},
	exited: function(direction) {
		$(this.element).find('.parallax-slider').hide();
	}
});

var parallax2 = new Waypoint.Inview({
	element: $('#parallax2')[0],
	enter: function(direction) {
		$(this.element).find('.parallax-slider').show();
	},
	exited: function(direction) {
		$(this.element).find('.parallax-slider').hide();
	}
});

var parallax3 = new Waypoint.Inview({
	element: $('#parallax3')[0],
	enter: function(direction) {
		$(this.element).find('.parallax-slider').show();
	},
	exited: function(direction) {
		$(this.element).find('.parallax-slider').hide();
	}
});

$('.parallax').parallax({
    naturalWidth: 1920,
    naturalHeight: 1080,
});



$('.menu a[href*="#"]:not([href="#"])').click(function() {

	$('.menu li').removeClass('active');
	$(this).closest('li').addClass('active');

    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 500);
        return false;
      }
    }
  });