jQuery(document).ready(function() {
    "use strict";

    /* ---------------------------------------------- /*
	 * WOW Animation
	/* ---------------------------------------------- */

	var wow = new WOW({
        mobile: false
    });

    wow.init();

    /* ---------------------------------------------- /*
	 * Countdown
	/* ---------------------------------------------- */

    jQuery('.countdown-container').countdown("2020/01/01", function(event) {
        jQuery(this).html(event.strftime(''
            + '<div><div>%D</div><i>days</i></div>'
            + '<div><div>%H</div><i>hours</i></div>'
            + '<div><div>%M</div><i>minutes</i></div>'
            + '<div><div>%S</div><i>seconds</i></div>'
        ));
    });

    /* ---------------------------------------------- /*
	 * Scroll Animation
	/* ---------------------------------------------- */

    jQuery('.inner-scroll').on('click', function(e) {
        var target = this.hash;
        var $target = $(target);

        jQuery('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 900, 'swing');

        e.preventDefault();
    });
});
