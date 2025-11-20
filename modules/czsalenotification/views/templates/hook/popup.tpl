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

<section class="product-notification" data-time="{$time}" data-cookie="{$cookietime}">
	<a href="javascript:void(0)" title="{l s='Close' mod='czsalenotification'}" class="notify-close">×</a>

	{if !empty($product)}
		{if $type == 1 || $type == 3 && empty($customer)}
			<div class="product-recommend">
				<div class="product-recommend-content">
					<div class="column-left col-sm-4">
						<a class="product-image" href="{$product.url}">
							<img src="{$product.img}" alt="{$product.name}">
						</a>
					</div>

					<div class="column-right col-sm-8">
						<div class="customer-detail">{l s='Someone Purchased' mod='czsalenotification'}</div>
						<a class="product-name" href="{$product.url}">{$product.name}</a>					
						<div class="time-ago"> {rand(1,59)} {l s='minutes ago' mod='czsalenotification'}</div>
					</div>
				</div>
			</div>

			<div class="hide">
				{foreach from=$products item=item_p}
					<div
						class="data-product"
						data-id="{$item_p.id_product}"
						data-image="{$item_p.img}"
						data-url="{$item_p.url}"
						data-title="{$item_p.name}"
						data-alt="{$item_p.name}" 
						data-time=" {rand(1,59)} {l s='minutes ago' mod='czsalenotification'}"
						>
					</div>
				{/foreach}
			</div>
		{/if}

		{if $type == 2 || $type == 3 && !empty($customer)}
			<div class="product-recommend">
				
				<div class="product-recommend-content">
					<div class="column-left col-sm-4">
						<a class="product-image" href="{$product.url}">
							<img src="{$product.img}" alt="{$product.name}">
						</a>
					</div>

				    <div class="column-right col-sm-8">
						<a class="product-name" href="{$product.url}">{$product.name}</a>
						<div class="time-ago">
				      		{l s='Puchased ' mod='czsalenotification'} {rand(1,59)} {l s='minutes ago' mod='czsalenotification'}
				      	</div>
					
						<div class="customer-detail">
							{$customer.name} ({$customer.city})
						</div>
				    </div>
			    </div>
			</div>

			<div class="hide">				 
				{foreach from=$customers item=customer}
					{foreach from=$products item=item_p}
						<div
							class="data-product"
							data-id="{$item_p.id_product}"
							data-image="{$item_p.img}"
							data-url="{$item_p.url}"
							data-title="{$item_p.name}"
							data-alt="{$item_p.name}" 
							data-detail="{$customer.name} ({$customer.city})"
							data-time="{l s='Puchased ' mod='czsalenotification'} {rand(1,59)} {l s='minutes ago' mod='czsalenotification'}"
							>	
						</div>
					{/foreach}
				{/foreach}				 
			</div>
		{/if}
	{/if}
</section>

{if $position == 1}
	<style type="text/css">
		.product-notification {
			top: 15px;
			left: 15px;
		}
	</style>
{else if $position == 2}
	<style type="text/css">
		.product-notification {
			top: 15px;
			right: 15px;
		}
	</style>
{else if $position == 4}
	<style type="text/css">
		.product-notification {
			bottom: 15px;
			right: 15px;
		}
	</style>
{else}
	<style type="text/css">
		.product-notification {
			bottom: 15px;
			left: 15px;
		}
	</style>
{/if}