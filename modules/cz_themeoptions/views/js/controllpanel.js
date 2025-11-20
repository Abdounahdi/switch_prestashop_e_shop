 /*
  * 2007-2020 PrestaShop
  *
  * NOTICE OF LICENSE
  *
  * This source file is subject to the Academic Free License (AFL 3.0)
  * that is bundled with this package in the file LICENSE.txt.
  * It is also available through the world-wide-web at this URL:
  * http://opensource.org/licenses/afl-3.0.php
  * If you did not receive a copy of the license and are unable to
  * obtain it through the world-wide-web, please send an email
  * to license@prestashop.com so we can send you a copy immediately.
  *
  * DISCLAIMER
  *
  * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
  * versions in the future. If you wish to customize PrestaShop for your
  * needs please refer to http://www.prestashop.com for more information.
  *
  *  @author PrestaShop SA <contact@prestashop.com>
  *  @copyright  2007-2020 PrestaShop SA
  *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
  *  International Registered Trademark & Property of PrestaShop SA
  */

 $(document).ready(function () {
	
	// Show/Hide Control Panel
	$('.panel-close').click(function () {
	   if ($(this).hasClass('hidepanel')) {
		  $(this).removeClass('hidepanel');
		  $(this).addClass('showpanel');
		  $('.panel_content').animate({
			 right: '0px'
		  }, 450);
	   } else {
		  $(this).removeClass('showpanel');
		  $(this).addClass('hidepanel');
		  $('.panel_content').animate({
			right: '-300px'
		 }, 450);
	   }
	});

	// Default Skin Option
	$('.color-item').click(function () {
		var color = $(this).data("color");
		$(':root').css('--primary-color', color);
		$('#primaryColor').minicolors('value', color);
		$('#linkHoverColor').minicolors('value', color);
		$('#priceColor').minicolors('value', color);
	});

	// Primary Color Option
	$('#primaryColor').minicolors({
		defaultValue: '34373c',
		format: 'Hue',
		position: 'bottom right',
		theme: 'bootstrap',
		change: function(value, opacity) {
			$(':root').css('--primary-color', value);
		}
	});

	// Secondary Color Option
	$('#secondaryColor').minicolors({
		defaultValue: 'ffffff',
		format: 'Hue',
		position: 'bottom right',
		theme: 'bootstrap',
		change: function(value) {
			$(':root').css('--secondary-color', value);
		}
	});

	// Price Color Option
	$('#priceColor').minicolors({
		defaultValue: '222222',
		format: 'Hue',
		position: 'bottom right',
		theme: 'bootstrap',
		change: function(value) {
			$(':root').css('--price-color', value) ;
		}
	});

	// Link Hover Color Option
	$('#linkHoverColor').minicolors({
		defaultValue: '888888',
		format: 'Hue',
		position: 'bottom right',
		theme: 'bootstrap',
		change: function(value) {
			$(':root').css('--link-hover-color', value) ;
		}
	});

	// Body Font Selection
	$('#bodyFont').change(function() {
		$("#body_font").attr("href", $(this).children('option:selected').data('link'))
		$(':root').css('--body-font-family', this.value);
	});

	// Body Font Size Selection
	$('#bodyFontSize').change(function() {
		$(':root').css('--body-font-size', this.value);
	});

	// Title Font Selection
	$('#titleFont').change(function() {
		$("#title_font").attr("href", $(this).children('option:selected').data('link'))
		$(':root').css('--title-font-family', this.value);
	});

	// Banner Font Selection
	$('#bannerFont').change(function() {
		$("#banner_font").attr("href", $(this).children('option:selected').data('link'))
		$(':root').css('--banner-font-family', this.value);
	});

	// Box/Full Width Layout Switcher
	$('#layoutBoxed').click(function () {
		$('body').addClass('box_layout');
		$('#pattern_block').css('display', 'block');
	});
	$('#layoutWide').click(function () {
		$('body').removeClass('box_layout');
		$('#pattern_block').css('display', 'none');
		$('body').removeAttr("style");
	});

	// Body Background Color Option
	$('#bodyBkgColor').minicolors({
		defaultValue: 'ffffff',
		format: 'Hue',
		position: 'bottom right',
		theme: 'bootstrap',
		change: function(value, opacity) {
			$(':root').css('--box-bodybkg-color', value);
		}
	});

	// Body Background pattern Option
	$('#pattern_block .pattern-item').click(function () {
		$('body').css("background-image", 'url(' + $(this).data('image-url') + ')');
		$('body').css("background-repeat", 'repeat');
	});

	// Sticky Header Switcher
	$('#yesSticky').click(function () {
		if($(window).scrollTop() > 320){
			$("#header .header-top").addClass('fixed');
		}
	});
	$('#noSticky').click(function () {
		$("#header .header-top").removeClass('fixed');
	});

	$(window).bind('scroll', function () {
		if($('#yesSticky').is(':checked') && $(window).scrollTop() > 320) {
			$('.header-top').addClass('fixed');
		} else {
			$('.header-top').removeClass('fixed');
		}
	});

	// Border Radius Switcher
	$('#yesRadius').click(function () {
		$(':root').css('--border-radius', '5px'); 
	});
	$('#noRadius').click(function () {
		$(':root').css('--border-radius', '0px')
	});


	function resetControlPanel() {
		var style = getComputedStyle(document.body)
		$('#primaryColor').minicolors('value', style.getPropertyValue('--primary-color'));
		$('#secondaryColor').minicolors('value', style.getPropertyValue('--secondary-color'));
		$('#priceColor').minicolors('value', style.getPropertyValue('--price-color'));
		$('#linkHoverColor').minicolors('value', style.getPropertyValue('--link-hover-color'));
		$('#bodyBkgColor').minicolors('value', style.getPropertyValue('--box-bodybkg-color'));
		
		$("#bodyFont").val(style.getPropertyValue('--body-font-family'));
		$("#titleFont").val(style.getPropertyValue('--title-font-family'));
		$("#bannerFont").val(style.getPropertyValue('--banner-font-family'));
		$('#bodyFontSize').val(style.getPropertyValue('--body-font-size'));

		
		if(CZBOX_LAYOUT == 1){
			$("#layoutBoxed").prop('checked', true);
			$('body').addClass('box_layout')
			$('#pattern_block').css('display', 'block');
		} else {
			$("#layoutWide").prop('checked', true);
			$('body').removeClass('box_layout')
			$('#pattern_block').css('display', 'none');
		}
		
		if(CZSTICKY_HEADER == 1){
			$("#yesSticky").prop('checked', true);
		} else {
			$("#noSticky").prop('checked', true);
		}

		if(CZBORDER_RADIUS == 1){ 
			$("#yesRadius").prop('checked', true);
		} else {
			$("#noRadius").prop('checked', true);
		}
	}

	resetControlPanel();

    $('#resetSettings').click(function () {
		$('body, html').removeAttr("style");
		resetControlPanel();
    });

});
