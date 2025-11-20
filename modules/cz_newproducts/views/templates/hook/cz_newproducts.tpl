{*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<section class="newproducts clearfix">
	<div class="container">
		<h2 class="h1 products-section-title text-uppercase">
			<span>{l s='New products' mod='cz_newproducts'}</span>
		</h2>
	<div class="newproducts-wrapper">
	<div class="products">
		{assign var='sliderFor' value=9} <!-- Define Number of product for SLIDER -->
		{if $slider == 1 && $no_prod >= $sliderFor}
			<div class="newproduct-double-slide">
				<ul id="newproduct-carousel" class="cz-carousel product_list">
					{assign var='newProductCount' value=0}
					{assign var='newProductTotalCount' value=0}
					{foreach from=$products item=product name=czNewProducts}
						{$newProductTotalCount = $newProductCount++}
					{/foreach}
					
					{if $newProductCount > 4 && $slider == 1}
					{foreach from=$products item="product" name=czNewProducts}
					{if $smarty.foreach.czNewProducts.index % 2 == 0} 
					<li class="double-slideitem">
						<ul>
						   {/if}	
						   <li class="item">
							  {include file="catalog/_partials/miniatures/product.tpl" product=$product}
						   </li>
						   {if $smarty.foreach.czNewProducts.index % 2 != 0} 
						</ul>
					</li>
					{/if}
					{/foreach}
					{/if}				
				</ul>
			</div>
			
			<div class="customNavigation">
				<a class="btn prev newproduct_prev">&nbsp;</a>
				<a class="btn next newproduct_next">&nbsp;</a>
			</div>
			
		{else}
			<ul id="newproduct-grid" class="newproduct_grid product_list grid row gridcount">
				{foreach from=$products item="product"}
					<li class="product_item col-xs-12 col-sm-6 col-md-4 col-lg-3">
						{include file="catalog/_partials/miniatures/product.tpl" product=$product}
					</li>
				{/foreach}		
			</ul>
			<div class="view_more">
				<a class="all-product-link" href="{$allNewProductsLink}">
					{l s='All new products' mod='cz_newproducts'}
				</a>
			</div>
		{/if}
		</div>
</div>
	</div>
</section>

