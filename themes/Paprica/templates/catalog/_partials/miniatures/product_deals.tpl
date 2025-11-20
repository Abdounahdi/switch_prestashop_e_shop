{**
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
 *}
 
{block name='product_miniature_item'}
	<div class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
	  <div class="thumbnail-container col-xs-12 col-md-6">
			{block name='product_thumbnail'}						
        		{if $product.cover}
				<a href="{$product.url}" class="thumbnail product-thumbnail">
					<img
					class="lazyload" 
					src="{$urls.img_url}codezeel/image_loading.svg"
					data-src="{$product.cover.bySize.special_default.url}"
					alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
					loading="lazy"
					data-full-size-image-url = "{$product.cover.large.url}"
					>
					{hook h="displayCzHoverImage" id_product=$product.id_product home='special_default' large='large_default'}
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
            
			<div class="outer-functional">
				<div class="functional-buttons">

					{hook h='displayStWishlistButton' product=$product}
					{hook h='displayStCompareButton' product=$product}

					{block name='quick_view'}
						<div class="quick-view-btn">
							<a href="#" class="quick-view js-quick-view" data-link-action="quickview">
								<i class="material-icons search">&#xE417;</i> {l s='Quick view' d='Shop.Theme.Actions'}
							</a>
						</div>
					{/block}
				</div>
			</div>	
	   </div>
	
		<div class="product-description col-xs-12 col-md-6">
		    		
			  {block name='product_name'}
				<h3 class="h3 product-title"><a href="{$product.url}" content="{$product.url}">{$product.name|truncate:70:'...'}</a></h3>
			  {/block}

			  	{*{block name='product_description_short'}
				  <div id="product-description-short-{$product.id}" itemprop="description">{$product.description_short|truncate:70:'...' nofilter}</div>
			 	{/block}*}
		  
				{block name='product_reviews'}
					{hook h='displayProductListReviews' product=$product}
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
			 	
			
			 <div class="highlighted-informations{if !$product.main_variants} no-variants{/if}">
			  {block name='product_variants'}
				{if $product.main_variants}
				  {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
				{/if}
			  {/block}
			</div>

			<div class="qtyprogress">
				{if $product.quantity > 0}
					{l s='Items In Stock!' d='Shop.Theme.Global'}<strong class="quantity"> {$product.quantity} </strong>
				{else}
					{l s='Sorry, Item is Out of Stock.' d='Shop.Theme.Global'}
				{/if}
				
				<div class="progress">
					<div class="progress-bar" role="progressbar"></div>
				</div>
			</div>

			{hook h='PSProductCountdown' id_product=$product.id_product}
			
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