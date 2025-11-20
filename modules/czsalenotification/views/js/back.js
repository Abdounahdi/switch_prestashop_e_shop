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
$(document).ready(function() {
	var type = Number($('#CZSALENOTIFICATION_SELECT_TYPE').val());

	$('.table-customer').parent().removeClass('col-lg-9');
	$('.table-customer').parent().removeClass('col-lg-offset-3');

	if (type == 3) {
		$('.table-customer').closest('.form-group').show();
		$('#CZSALENOTIFICATION_CATEGORY').closest('.form-group').show();
	} else if (type == 2) {
		$('.table-customer').closest('.form-group').hide();
		$('#CZSALENOTIFICATION_CATEGORY').closest('.form-group').hide();
	} else {
		$('.table-customer').closest('.form-group').hide();
		$('#CZSALENOTIFICATION_CATEGORY').closest('.form-group').show();
	}

	slectType();
	addCustomer();
	deleteCustomer();
	czSearchProduct();
	removeProduct();
});

function removeProduct()
{
	$('.cz-remove').click(function() {
		$(this).closest('.cz-tagger-Tag').remove();
		var check = 1;
		var id = '';

		$('.cz-tagger-Tag').each(function() {
			if (check == 1) {
				id += $(this).find('span').data('id');
			} else {
				id += ',' + $(this).find('span').data('id');
			}

			check++;
		});

		$('.cz-list-product').val(id);
	});
}

function czSearchProduct()
{
	$('.cz-close').click(function() {
		$('.product-list').html('');
		$('.cz-close').hide();
	});

	$('#cz-search-product').keyup(function() {
		var name = $(this).val();
		var id_product = $('.cz-list-product').val();
		$('.cz-error').hide();
		$('cz-res').hide();
		$('.cz-close').hide();
		$('.product-list').html('');

		if (name.length >= 3) {
			$('.cz-loading').show();

			$.ajax({
		        type: 'GET',
		        url: url,
		        headers: { "cache-control": "no-cache" },
		        async: true,
		        cache: false,
		        dataType: "json",
		        data: {
		            token: cz_token,
		            id_product: id_product,
		            name: name,
		            action: 'searchProduct'
		        },
		        success: function (data)
		        {
					$('.cz-loading').hide();
		            $('cz-res').show();

		            if (data.success == 0) {
		            	$('.cz-error').html(data.message);
		            	$('.cz-error').show();
		            } else {
		            	$('.cz-close').show();
		            	$('.product-list').html(data.message);
		            	selectProduct(id_product);
		            }
		        },
    		});
		}
	});
}

function selectProduct(id_product)
{
	$('.cz-product-item').click(function() {
		var id = $(this).data('id');
		var name = $(this).data('name');

		var html = '<span class="cz-tagger-Tag">';
		html += '<span data-id="'+id+'">'+name+'</span>';
		html += '<i class="material-icons cz-remove">close</i>';
		html += '</span>';

		if (id_product != '') {
			id_product += ',' + id;
		} else {
			id_product += id;
		}

		$('.cz-product-tag').append(html);
		$('.cz-list-product').val(id_product);
		$('.product-list').html('');
		$('.cz-close').hide();
		removeProduct();
	});
}

function slectType()
{
	var val = Number($('#CZSALENOTIFICATION_SELECT_TYPE').val());
	hideShow(val);
	
	$('#CZSALENOTIFICATION_SELECT_TYPE').change(function() {
		val = Number($(this).val());
		hideShow(val);
	});
}

function hideShow(val)
{
	if (val == 1) {
		$('.table-customer').closest('.form-group').hide();
		$('#CZSALENOTIFICATION_CATEGORY').closest('.form-group').show();
	} else if (val == 2) {
		$('.table-customer').closest('.form-group').hide();
		$('#CZSALENOTIFICATION_CATEGORY').closest('.form-group').hide();
	} else {
		$('.table-customer').closest('.form-group').show();
		$('#CZSALENOTIFICATION_CATEGORY').closest('.form-group').hide();
	}
}

function addCustomer()
{
	$('.cz-add').click(function() {
		/*var count = $('.item-customer').length;

		if (count >= 2) {
			alert(cz_text);

			return;
		}*/

		var html = '<tr class="item-tr item-customer">' + $('.tr-template').html() + '</tr>';
		html = html.replace('name="name"', 'name="cz_name[]"');
		html = html.replace('name="city"', 'name="cz_city[]"');
		$('.cz-body').append(html);
		deleteCustomer();
	});
}

function deleteCustomer()
{
	$('.cz-delete').on('click', function(e) {
		e.preventDefault();
		$(this).closest('.item-customer').remove();
	});
}