

if (CZBOX_LAYOUT == 1) {
	$('body').addClass('box_layout')
}
if (CZSTICKY_HEADER == 1) {
	function stickyheader(){
		if ($(document).width() <= 991) {
			// ---------------- Fixed header responsive ----------------------
			$(window).bind('scroll', function () {
				if ($(window).scrollTop() > 170) {
					$('.header-top').addClass('fixed');
				} else {
					$('.header-top').removeClass('fixed');
				}
			});
		}
		else if($(document).width() >= 992)
		{
			$(window).bind('scroll', function () {
				if ($(window).scrollTop() > 270) {
					$('.header-top').addClass('fixed');
				} else {
					$('.header-top').removeClass('fixed');
				}
			});
		}
	}

	$(document).ready(function(){stickyheader();});
	$(window).resize(function(){stickyheader();});
}