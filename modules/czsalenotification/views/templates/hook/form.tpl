{**
* 2007-2017 PrestaShop
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
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2017 PrestaShop SA
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* International Registered Trademark & Property of PrestaShop SA
*}

<div class="table-customer">
	<hr>
	<div class="alert alert-info">
		<p>{l s='Create Product Sale' mod='czsalenotification'}</p>
	</div>

	<div class="cz-product">
		<div class="cz-product-tag">
			{if !empty($products)}
				{foreach from=$products item=product}
					<span class="cz-tagger-Tag">
						<span data-id="{$product.id_product}">{$product.name}</span>
						<i class="material-icons cz-remove">close</i>
					</span>
				{/foreach}
			{/if}
		</div>

		<input type="hidden" class="cz-list-product" name="CZSALENOTIFICATION_LIST_PRODUCT" value="{Configuration::get('CZSALENOTIFICATION_LIST_PRODUCT')}">

		<div class="form-group">
			<label class="control-label col-lg-3">{l s='Search Product' mod='czsalenotification'}</label>

			<div class="col-lg-3">
				<input type="text" id="cz-search-product" placeholder="{l s='Search Product' mod='czsalenotification'}">

				<div class="cssload-container cz-loading">
					<div class="cssload-double-torus"></div>
				</div>
			</div>
		</div>

		<div class="cz-res">
			<div class="cz-error alert alert-danger"></div>

			<p class="cz-close">
				<i class="material-icons">close</i>
			</p>

			<div class="product-list">
			</div>
		</div>
	</div>

	<div class="alert alert-info">
		<p>{l s='Create Customer Sale' mod='czsalenotification'}</p>
	</div>

	<table class="table cz-table">
		<thead>
			<tr class="title-table">
				<td>
					{l s='Customer Name' mod='czsalenotification'}
				</td>
				<td>
					{l s='Customer City' mod='czsalenotification'}
				</td>
				<td>
					{l s='Action' mod='czsalenotification'}
				</td>
			</tr>
		</thead>
		<tbody class="cz-body">
			<tr class="tr-template" style="display:none;">
				<td>
					<input required="" type="text" name="name">
				</td>
				<td>
					<input required="" type="text" name="city">
				</td>
				<td>
					<a href="#" class="cz-delete btn">
						<i class="material-icons">delete</i>
					</a>
				</td>
			</tr>

			{if !empty($customers)}
			{foreach from=$customers item=customer}
			<tr class="item-tr item-customer">
				<td>
					<input required="" type="text" name="cz_name[]" value="{$customer.name}">
				</td>

				<td>
					<input required="" type="text" name="cz_city[]" value="{$customer.city}">
				</td>

				<td>
					<a href="#" class="cz-delete btn">
						<i class="material-icons">delete</i>
					</a>
				</td>
			</tr>
			{/foreach}
			{/if}
		</tbody>
	</table>

	<button type="button" class="cz-add btn btn-primary">
		<i class="material-icons">add</i>
		{l s='Add' mod='czsalenotification'}
	</button>
</div>