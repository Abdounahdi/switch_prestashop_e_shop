
function additionalCarousel(sliderId){
	 /*======  curosol For Additional ==== */
	 var czadditional = $(sliderId);
      czadditional.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
		  itemsDesktop : [1199,3], 
		  itemsDesktopSmall : [991,2], 
		  itemsTablet: [767,3],
		  itemsTabletSmall: [350,2],
		  itemsMobile : [320,2]
      });
      // Custom Navigation Events
      $(".additional_next").click(function(){
        czadditional.trigger('owl.next');
      })
      $(".additional_prev").click(function(){
        czadditional.trigger('owl.prev');
      });
}

 // Cart Slide Toggle
 $(document).on("click", "#header .blockcart .blockcart-header .shopping-cart", function () {
	$("body").addClass("cartslide_active");
	$(".overlay").addClass("overlay_active");
});
$(document).on("click", ".close-icon, .overlay", function () {
	$("body").removeClass("cartslide_active");
	$(".overlay").removeClass("overlay_active");
});
$(document).on("click", ".cart_block .remove-from-cart .material-icons",
	function () {
	$(".overlay").addClass("overlay_active");
	}
);



$(document).ready(function(){
	
	bindGrid();
	additionalCarousel('#main .additional-carousel');
	
	$('.cart_block.dropdown-menu').on('click',function (e) {
		e.stopPropagation();
	});

	// ---------------- Add Class megamenu ----------------------
	$("#horizontal-menu .sub-menu li:has(ul)").parent().parent().addClass("megamenu");
	$("#czverticalmenublock ul#top-menu li:has(ul)").parent().parent().addClass("megamenu");
 
	
	// Add/Remove acttive class on menu active in responsive  
	$('#menu-icon').on('click', function() {
		$(this).toggleClass('active');
	});
	
	$('input[name="email"], #search_widget input[type="text"]').focus(function(){
		$(this).data('placeholder',$(this).attr('placeholder')).attr('placeholder','');
	}).blur(function(){
		$(this).attr('placeholder',$(this).data('placeholder'));
	});
	
	
	$('#header .search_button').click(function(event){			
		$(this).toggleClass('active');		
		event.stopPropagation();		
		$('#header .search_toggle').toggle("medium");		
		$( "#header .search-widget form input[type=text]" ).focus();
	
	});
	
	$("#header .search_toggle").on("click", function (event) {
		event.stopPropagation();	
	});
	
	$('.pp-right-column .total-rating').on('click', function() {
		$('html, body').animate({scrollTop: $('#productCommentsBlock').offset().top}, 'slow');
	});

	/*======  Parallax  ====*/
	var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
	if(!isMobile) {
		if($(".parallax").length){  
			$(".parallax").sitManParallex({  invert: false });
		};
	}else{
		$(".parallax").sitManParallex({  invert: true });
	} 
	
	/* ---------------- start horizontal more menu setting ---------------------- */
		var max_elem = 6;

		if($(window).width() <= 1199){
			max_elem = 5;
		}	
		var items = $('.horizontal-menu ul#top-menu > li');	
		var surplus = items.slice(max_elem, items.length);
		
		var menu_more_title = $("#moremenu_text").text();
	
		surplus.wrapAll('<li class="category more_menu" id="more_menu"><div id="top_moremenu" class="popover sub-menu js-sub-menu collapse"><ul class="top-menu more_sub_menu">');
	
		$('.horizontal-menu ul#top-menu .more_menu').prepend('<a href="#" class="dropdown-item" data-depth="0"><span class="pull-xs-right hidden-md-up"><span data-target="#top_moremenu" data-toggle="collapse" class="navbar-toggler collapse-icons"><i    class="material-icons add">&#xE313;</i><i class="material-icons remove">&#xE316;</i></span></span></span>'+ menu_more_title +'</a>');
	
		$('.horizontal-menu ul#top-menu .more_menu').mouseover(function(){
			$(this).children('div').css('display', 'block');
		})
		.mouseout(function(){
			$(this).children('div').css('display', 'none');
		});		
	/* ---------------- end more menu setting ----------------------	*/



	 /* ---------------- start Vertical menu setting ---------------------- */
	 var vmax_elem = 11;	
	 var vmenu_items = $('#czverticalmenublock ul#top-menu > li');	
 
	 var vmenu_more_title = $("#morecategory_text").text();
	 var vmenu_less_title = $("#lesscategory_text").text();
	 
	 if ($(window).width()<=1199){
		 var vmax_elem = 10;
	 }

		if (vmenu_items.length > vmax_elem) {
			$('#czverticalmenublock ul#top-menu').append('<li class="more_menu"><a href="#" class="vertical-menu-item" data-depth="0">'+ vmenu_more_title +'<span class="more_category"><i class="fa-icon add"></i></span></a></li>')
		}
		$('#czverticalmenublock ul#top-menu .more_menu').click(function(event) {
			event.preventDefault();	
			if ($(this).hasClass('active')) {
				vmenu_items.each(function(j) {
					if (j >= vmax_elem) {
						$(this).slideUp(200)
					}
				});
				$(this).removeClass('active');
				$('#czverticalmenublock ul#top-menu .more_menu').html('<a href="#" class="vertical-menu-item" data-depth="0">'+ vmenu_more_title +'<span class="more_category"><i class="fa-icon add"></i></span></a>')
			} else {
				vmenu_items.each(function(j) {
					if (j >= vmax_elem) {
						$(this).slideDown(200)
					}
				});
				$(this).addClass('active');
				$('#czverticalmenublock ul#top-menu .more_menu').html('<a href="#" class="vertical-menu-item" data-depth="0">'+ vmenu_less_title +'<span class="more_category"><i class="fa-icon remove">&nbsp;</i></span></a>')
			}
		});
		vmenu_items.each(function(j) {
			if (j >= vmax_elem) {
				$(this).css('display', 'none')
			}
		});
		
		
	/* ---------------- end Vertical menu setting ----------------------	*/
	
	
});

/*For Parallax Bredcrumb*/
function mobile(){
   
	var parallax = document.querySelectorAll(".breadcrumb"),
	   speed = 0.42;

	window.onscroll = function(){
	  [].slice.call(parallax).forEach(function(el,i){
  
		var windowYOffset = window.pageYOffset,
			elBackgrounPos = "50%" + -(windowYOffset * speed) + "px";
		
		el.style.backgroundPosition = elBackgrounPos;
  
	  });
	};
}
jQuery(document).ready(function() { mobile();});
jQuery(window).resize(function() { mobile();});



// Loading image before flex slider load
	$(window).load(function() { 
		$(".loadingdiv").removeClass("spinner"); 
	});

/// Flex slider load
$(window).load(function() {
	if($('.flexslider').length > 0){ 
		$('.flexslider').flexslider({		
			slideshowSpeed: $('.flexslider').data('interval'),
			pauseOnHover: $('.flexslider').data('pause'),
			animation: "fade"
		});
	}
});	

// Scroll page bottom to top
	$(window).scroll(function() {
		if ($(this).scrollTop() > 500) {
			$('.top_button').fadeIn(500);
		} else {
			$('.top_button').fadeOut(500);
		}
	});							
	$('.top_button').click(function(event) {
		event.preventDefault();		
		$('html, body').animate({scrollTop: 0}, 800);
	});

/*======  Carousel Slider For blog Product ==== */
	
	var czblog = $("#blog-carousel");
	czblog.owlCarousel({
		items : 1, //10 items above 1000px browser width
		itemsDesktop : [1199,1], 
		itemsDesktopSmall : [991,2], 
		itemsTablet: [480,1]
	});
	// Custom Navigation Events
	$(".blog_next").click(function(){
		czblog.trigger('owl.next');
	})
	$(".blog_prev").click(function(){
		czblog.trigger('owl.prev');
	});

/*======  Carousel Slider For Feature Product ==== */
	
	var czfeature = $("#feature-carousel");
	czfeature.owlCarousel({
		items : 3, //10 items above 1000px browser width
		itemsDesktop : [1199,3], 
		itemsDesktopSmall : [991,2], 
		itemsTablet: [650,1], 
		itemsMobile : [380,1] 
	});
	// Custom Navigation Events
	$(".feature_next").click(function(){
		czfeature.trigger('owl.next');
	})
	$(".feature_prev").click(function(){
		czfeature.trigger('owl.prev');
	});



/*======  Carousel Slider For New Product ==== */
	
	var cznewproduct = $("#newproduct-carousel");
	cznewproduct.owlCarousel({
	    items : 4, //10 items above 1000px browser width
		itemsDesktop : [1199,4], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [575,2], 
		itemsMobile : [319,1] 
	});
	// Custom Navigation Events
	$(".newproduct_next").click(function(){
		cznewproduct.trigger('owl.next');
	})
	$(".newproduct_prev").click(function(){
		cznewproduct.trigger('owl.prev');
	});



/*======  Carousel Slider For Bestseller Product ==== */
	
	var czbestseller = $("#bestseller-carousel");
	czbestseller.owlCarousel({
	    items : 4, //10 items above 1000px browser width
		itemsDesktop : [1199,4], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [575,2], 
		itemsMobile : [319,1]  
	});
	// Custom Navigation Events
	$(".bestseller_next").click(function(){
		czbestseller.trigger('owl.next');
	})
	$(".bestseller_prev").click(function(){
		czbestseller.trigger('owl.prev');
	});



/*======  Carousel Slider For Special Product ==== */
	var czspecial = $("#special-carousel");
	czspecial.owlCarousel({
		items : 2, //10 items above 1000px browser width
		itemsDesktop : [1199,2], 
		itemsDesktopSmall : [991,1], 
		itemsTablet: [575,1], 
		itemsMobile : [319,1] 
	});
	// Custom Navigation Events
	$(".special_next").click(function(){
		czspecial.trigger('owl.next');
	})
	$(".special_prev").click(function(){
		czspecial.trigger('owl.prev');
	});


/*======  Carousel Slider For Accessories Product ==== */

	var czaccessories = $("#accessories-carousel");
	czaccessories.owlCarousel({
     	items : 4, //10 items above 1000px browser width
		itemsDesktop : [1199,4], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [575,2], 
		itemsMobile : [319,1] 
	});
	// Custom Navigation Events
	$(".accessories_next").click(function(){
		czaccessories.trigger('owl.next');
	})
	$(".accessories_prev").click(function(){
		czaccessories.trigger('owl.prev');
	});


/*======  Carousel Slider For Category Product ==== */

	var czproductscategory = $("#productscategory-carousel");
	czproductscategory.owlCarousel({
    	items : 4, //10 items above 1000px browser width
		itemsDesktop : [1199,4], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [575,2], 
		itemsMobile : [319,1] 
	});
	// Custom Navigation Events
	$(".productscategory_next").click(function(){
		czproductscategory.trigger('owl.next');
	})
	$(".productscategory_prev").click(function(){
		czproductscategory.trigger('owl.prev');
	});


/*======  Carousel Slider For Viewed Product ==== */

	var czviewed = $("#viewed-carousel");
  	czviewed.owlCarousel({
    	items : 4, //10 items above 1000px browser width
		itemsDesktop : [1199,4], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [575,2], 
		itemsMobile : [319,1] 
	});
	// Custom Navigation Events
	$(".viewed_next").click(function(){
		czviewed.trigger('owl.next');
	})
	$(".viewed_prev").click(function(){
		czviewed.trigger('owl.prev');
	});

/*======  Carousel Slider For Crosssell Product ==== */

	var czcrosssell = $("#crosssell-carousel");
	czcrosssell.owlCarousel({
	    items : 4, //10 items above 1000px browser width
		itemsDesktop : [1199,4], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [575,2], 
		itemsMobile : [319,1] 
	});
	// Custom Navigation Events
	$(".crosssell_next").click(function(){
		czcrosssell.trigger('owl.next');
	})
	$(".crosssell_prev").click(function(){
		czcrosssell.trigger('owl.prev');
	});

/*======  curosol For Manufacture ==== */
	 var czbrand = $("#brand-carousel");
      czbrand.owlCarousel({
     	 items : 6, //10 items above 1000px browser width
     	 itemsDesktop : [1199,5], 
     	 itemsDesktopSmall : [991,4],
     	 itemsTablet: [767,3], 
		 itemsTabletSmall: [480,2], 
     	 itemsMobile : [320,1],
		 autoPlay: true
      });
      // Custom Navigation Events
      $(".brand_next").click(function(){
        czbrand.trigger('owl.next');
      })
      $(".brand_prev").click(function(){
        czbrand.trigger('owl.prev');
      });


/*======  Carousel Slider For For Tesimonial ==== */

	  var cztestimonial = $("#testimonial-carousel");
     	 cztestimonial.owlCarousel({
			 items : 1, //10 items above 1000px browser width
			 itemsDesktop : [1199,1], 
			 itemsDesktopSmall : [991,1],
			 itemsTablet : [767,1],
			 itemsMobile : [320,1] 
      });

		/* Custom Navigation Events*/
      $(".cztestimonial_next").click(function(){
        cztestimonial.trigger('owl.next');
      });

      $(".cztestimonial_prev").click(function(){
        cztestimonial.trigger('owl.prev');
      });

/*======  curosol For Our Category list product Slider  ==== */

	  var czourcategory = $("#ourcategory-carousel");
      czourcategory.owlCarousel({
     	 items : 3, //10 items above 1000px browser width
     	 itemsDesktop : [1199,3], 
     	 itemsDesktopSmall : [991,2],
		 itemsTablet : [767,2],
     	 itemsTabletSmall: [575,1], 
     	 itemsMobile : [400,1],
		/* autoPlay: true*/
      });
	  
	  	/* Custom Navigation Events*/
      $(".category_next").click(function(){
        czourcategory.trigger('owl.next');
      });

      $(".category_prev").click(function(){
        czourcategory.trigger('owl.prev');
      });


function bindGrid()
{
	var view = $.totalStorage("display");

	if (view && view != 'grid')
		display(view);
	else
		$('.display').find('li#grid').addClass('selected');

	$(document).on('click', '#grid', function(e){
		e.preventDefault();
		display('grid');
	});

	$(document).on('click', '#list', function(e){
		e.preventDefault();
		display('list');		
	});	
}

function display(view)
{
	if (view == 'list')
	{
		$('#products ul.product_list').removeClass('grid').addClass('list row');
		$('#products .product_list > li').removeClass('col-xs-12 col-sm-6 col-md-6 col-lg-4').addClass('col-xs-12');
		
		
		$('#products .product_list > li').each(function(index, element) {
			var html = '';
			html = '<div class="product-miniature js-product-miniature" data-id-product="'+ $(element).find('.product-miniature').data('id-product') +'" data-id-product-attribute="'+ $(element).find('.product-miniature').data('id-product-attribute') +'" itemscope itemtype="http://schema.org/Product">';
				html += '<div class="thumbnail-container col-xs-4 col-xs-5 col-md-4">' + $(element).find('.thumbnail-container').html() + '</div>';
				
				html += '<div class="product-description center-block col-xs-4 col-xs-7 col-md-8">';
					html += '<h3 class="h3 product-title" itemprop="name">'+ $(element).find('h3').html() + '</h3>';
					
					var comment = $(element).find('.comments_note').html();       // check : Comment module is enabled
					if (comment != null) {
						html += '<div class="comments_note">'+ $(element).find('.comments_note').html() + '</div>';
					}
					
					var price = $(element).find('.product-price-and-shipping').html();       // check : catalog mode is enabled
					if (price != null) {
						html += '<div class="product-price-and-shipping">'+ price + '</div>';
					}
					
					html += '<div class="product-detail">'+ $(element).find('.product-detail').html() + '</div>';
					
					var colorList = $(element).find('.highlighted-informations').html();
					if (colorList != null) {
						html += '<div class="highlighted-informations">'+ colorList +'</div>';
					}
					
					html += '<div class="product-actions">'+ $(element).find('.product-actions').html() +'</div>';
					
				html += '</div>';
			html += '</div>';
		$(element).html(html);
		});
		$('.display').find('li#list').addClass('selected');
		$('.display').find('li#grid').removeAttr('class');
		$.totalStorage('display', 'list');

		if (typeof(StWishlistButtonAction) != 'undefined') {
			StWishlistButtonAction()
		}
		if (typeof(StCompareButtonAction) != 'undefined') {
			StCompareButtonAction()
		}
	}
	else
	{
		$('#products ul.product_list').removeClass('list').addClass('grid row');
		$('#products .product_list > li').removeClass('col-xs-12').addClass('col-xs-12 col-sm-6 col-md-6 col-lg-4');
		$('#products .product_list > li').each(function(index, element) {
		var html = '';
		html += '<div class="product-miniature js-product-miniature" data-id-product="'+ $(element).find('.product-miniature').data('id-product') +'" data-id-product-attribute="'+ $(element).find('.product-miniature').data('id-product-attribute') +'" itemscope itemtype="http://schema.org/Product">';
			html += '<div class="thumbnail-container">' + $(element).find('.thumbnail-container').html() +'</div>';
			
			html += '<div class="product-description">';
			
				var comment = $(element).find('.comments_note').html();       // check : Comment module is enabled
				if (comment != null) {
					html += '<div class="comments_note">'+ $(element).find('.comments_note').html() + '</div>';
				}
				
				html += '<h3 class="h3 product-title" itemprop="name">'+ $(element).find('h3').html() +'</h3>';
			
				var price = $(element).find('.product-price-and-shipping').html();       // check : catalog mode is enabled
				if (price != null) {
					html += '<div class="product-price-and-shipping">'+ price + '</div>';
				}
				
				html += '<div class="product-detail">'+ $(element).find('.product-detail').html() + '</div>';
				
				//html += '<div class="product-actions">'+ $(element).find('.product-actions').html() +'</div>';
				
				var colorList = $(element).find('.highlighted-informations').html();
				if (colorList != null) {
					html += '<div class="highlighted-informations">'+ colorList +'</div>';
				}
				
			html += '</div>';
		html += '</div>';
		$(element).html(html);
		});
		$('.display').find('li#grid').addClass('selected');
		$('.display').find('li#list').removeAttr('class');
		$.totalStorage('display', 'grid');

		if (typeof(StWishlistButtonAction) != 'undefined') {
			StWishlistButtonAction()
		}
		if (typeof(StCompareButtonAction) != 'undefined') {
			StCompareButtonAction()
		}
	}
}


function responsivecolumn(){
	
	if ($(document).width() <= 991)
	{
		$('.container #columns_inner #left-column').appendTo('.container #columns_inner');
		// ---------------- Fixed header responsive ----------------------
		// $(window).bind('scroll', function () {
		// 	if ($(window).scrollTop() > 170) {
		// 		$('.header-top').addClass('fixed');
		// 	} else {
		// 		$('.header-top').removeClass('fixed');
		// 	}
		// });
		$( "#header #desktop_cart" ).insertAfter( "#header .header-top .container .header_logo" );
		$('#czheadercmsblock').appendTo('.mobile-menu-inner');
	}
	else if($(document).width() >= 992)
	{
		$('.container #columns_inner #left-column').prependTo('.container #columns_inner');
		// $(window).bind('scroll', function () {
		// 	if ($(window).scrollTop() > 270) {
		// 		$('.header-top').addClass('fixed');
		// 	} else {
		// 		$('.header-top').removeClass('fixed');
		// 	}
		// });
	$( "#czheadercmsblock" ).insertAfter( "#header .header-top .container .user-info" );
	$( "#header #desktop_cart" ).insertAfter( "#header .header-top-inner .container .horizontal-menu" );
	}

    $('#language-selector').appendTo('.user-info > ul.dropdown-menu');
    $('#currency-selector').appendTo('.user-info > ul.dropdown-menu');
}
	
$(document).ready(function(){responsivecolumn();});
$(window).resize(function(){responsivecolumn();});


$(document).ready(function(){ 
	stockProgressBar();
	prestashop.on('updatedProduct',function(event){    	
		stockProgressBar();			
	});
});

function stockProgressBar(){
	$('.product-information, .product-description').each(function(){
		var $desc = jQuery(this).find('.progress');
		var $qty = jQuery(this).find('.quantity');
		var $pbar = jQuery(this).find('.progress-bar');
		var $progress = $desc;
		var $progressBar = $pbar;
		var $quantity = $qty.html();
		var currentWidth = parseInt($progressBar.css('width'));
		var allowedWidth = parseInt($progress.css('width'));
		var addedWidth = currentWidth + parseInt($quantity);
		if (addedWidth > allowedWidth) {
		addedWidth = allowedWidth;
		}
		var progress = (addedWidth / allowedWidth) * 100;
		$progressBar.animate({width: progress + '%' }, 100);
	});
}

