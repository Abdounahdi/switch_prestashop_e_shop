/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */
var $productNotificationClass = $('.product-notification');
var duration = $productNotificationClass.data('time') || 0;
var cookieTime = $productNotificationClass.data('cookie') || 0;

if (duration == 0 || duration == '') {
	duration = 7000;
} else{
	duration = duration+3000;
}

if (cookieTime == 0 || cookieTime == '') {
	cookieTime = 12;
} 

$(document).ready(function() {
	SomeonePurchased();
});

function createNotifCookie(cookiename, cookievalue, exdays) {
	const d = new Date();
	d.setTime(d.getTime() + (exdays*60*60*1000));
	let expires = "expires="+ d.toUTCString();
	document.cookie = cookiename + "=" + cookievalue + ";" + expires + ";path=/";
}

function getNotifCookie(cookiename) {
	let name = cookiename + "=";
	let decodedCookie = decodeURIComponent(document.cookie);
	let ca = decodedCookie.split(';');
	for(let i = 0; i <ca.length; i++) {
	  let c = ca[i];
	  while (c.charAt(0) == ' ') {
		c = c.substring(1);
	  }
	  if (c.indexOf(name) == 0) {
		return c.substring(name.length, c.length);
	  }
	}
	return "";
}

function SomeonePurchased()
{
	if (getNotifCookie("cookieNotificat") == 'closed') {
		$productNotificationClass.remove();
	}

	$('.notify-close').on('click',function() {
		$productNotificationClass.remove();
		createNotifCookie("cookieNotificat",'closed', cookieTime);
	});

	function toggleNotification() {

		var arrayProducts = $('.data-product'),
		randomProduct = Math.floor(Math.random() * arrayProducts.length),
		Object = $(arrayProducts[randomProduct]);

		$productNotificationClass.find('.product-image').attr('href', Object.data('url')).find('img').attr('src', Object.data('image'));
		$productNotificationClass.find('.product-name').text(Object.data('title')).attr('href', Object.data('url'));
		$productNotificationClass.find('.time-ago').text(Object.data('time'));
		$productNotificationClass.find('.customer-detail').text(Object.data('detail'));
		
		$productNotificationClass.addClass('active');

		if ($productNotificationClass.hasClass('active')) {
			setTimeout(function(){ 
				$productNotificationClass.removeClass('active');
			}, 3000);
		}
	}
	
	if (duration !== 0) {
		setInterval(toggleNotification, duration);
	}
}