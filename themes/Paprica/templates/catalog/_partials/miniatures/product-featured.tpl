{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='product_miniature_item'}
<div class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" 
	data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
	<div class="thumbnail-container col-sm-6 col-md-6">
		{block name='product_thumbnail'}
		  	{if $product.cover}
				<a href="{$product.url}" class="thumbnail product-thumbnail">
					<img
					class="lazyload" 
					src="{$urls.img_url}codezeel/image_loading.svg"
					data-src="{$product.cover.bySize.feature_default.url}"
					alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
					data-full-size-image-url = "{$product.cover.large.url}"
					>
				</a>
			 {else}
				<a href="{$product.url}" class="thumbnail product-thumbnail">
					<img src="{$urls.no_picture_image.bySize.home_default.url}" 
					loading="lazy"
					/>
				</a>
			{/if}
		{/block}
		
		{include file='catalog/_partials/product-flags.tpl'}
				
		{block name='quick_view'}
			<a href="#" class="quick-view" data-link-action="quickview">
				<i class="material-icons search">&#xE417;</i> {l s='Quick view' d='Shop.Theme.Actions'}
			</a>
		{/block}
	</div>
		
	<div class="product-description col-sm-6 col-md-6">
		  {*<span class="product-category"> {$product.category} </span>*}
		  
		  {block name='product_reviews'}
			{hook h='displayProductListReviews' product=$product}
	  	  {/block}
		  
		  {block name='product_name'}
			<span class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name}</a></span>
		  {/block}
		
			  
		  {block name='product_price_and_shipping'}
				{if $product.show_price}
				<div class="product-price-and-shipping">
					{if $product.has_discount}
						{hook h='displayProductPriceBlock' product=$product type="old_price"}

						<span class="regular-price" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
						{if $product.discount_type === 'percentage'}
						<span class="discount-percentage discount-product">{$product.discount_percentage}</span>
						{elseif $product.discount_type === 'amount'}
						<span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
						{/if}
					{/if}

					{hook h='displayProductPriceBlock' product=$product type="before_price"}

					<span class="price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
						{capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
						{if '' !== $smarty.capture.custom_price}
						{$smarty.capture.custom_price nofilter}
						{else}
						{$product.price}
						{/if}
					</span>

					{hook h='displayProductPriceBlock' product=$product type='unit_price'}

					{hook h='displayProductPriceBlock' product=$product type='weight'}
				</div>
				{/if}
			{/block}
				 					
			{block name='product_buy'}
				{if !$configuration.is_catalog}
					<div class="product-actions">
					{if !$product.main_variants}
						<form action="{$urls.pages.cart}" method="post" class="add-to-cart-or-refresh">
							<input type="hidden" name="token" value="{$static_token}">
							<input type="hidden" name="id_product" value="{$product.id}" class="product_page_product_id">
							<input type="hidden" name="id_customization" value="0" id="product_customization_id" class="js-product-customization-id">
							<button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url}disabled{/if}>
								{l s='Add to cart' d='Shop.Theme.Actions'}
							</button>
						</form>
					{else}
						<a href="{$product.url}" class="btn btn-primary add-to-cart view_page">
							{l s='Select Option' d='Shop.Theme.Actions'}
						</a>
					{/if}
					</div>
				{/if}
			{/block} 
				 
	</div>
</div>
{/block}